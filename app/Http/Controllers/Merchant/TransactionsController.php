<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\__init__;
use App\Http\Controllers\Controller;
use App\Http\Controllers\verifyNumberController;
use App\Imports\PayoutsImport;
use App\Imports\PayoutTestsImport;
use App\Imports\ValidateCsvFile;
use App\Models\Payout;
use App\Models\payout_test;
use App\Models\Transaction;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;

class TransactionsController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 12000);
    }

    public function index()
    {
        return view('merchant.transaction.add');
    }
    public function payout(){
        $payouts = DB::table('payouts')->where('userid', Auth::user()->id)->orderBy('id','desc')->get();
        return view('merchant.payout.liste', compact('payouts'));
    }

    public function payout_logs(){
        $logs = DB::table('mobile_money')->where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('merchant.payout.logs', compact('logs'));
    }


    public function process_payout(Request $request){
        
        $validator = Validator::make($request->all(), [
            'customFile' => 'required|mimes:csv,xlsx',
            'no_transaction' => 'required|string|max:255',
        ],[
            'no_transaction.required' => 'The number of transaction is required',
            'customFile.required' => 'You must select a file',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }
        $file = $request->file('customFile');
        $no_trx = $request->no_transaction;

        if ($file) {
            $filename = $file->getClientOriginalName();
            // dd($filename);
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes
            //Check for file extension and size
            $this->checkUploadedFileProperties($extension, $fileSize);
            //Where uploaded file will be stored on the server 
            $location = 'uploads'; //Created an "uploads" folder for that
            // Upload file
            $file->move($location, $filename);
            // In case the uploaded file path is to be stored in the database 
            $filepath = public_path($location . "/" . $filename);
            // Reading file
            $file = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;
            //Read the contents of the uploaded file 
            while (($filedata = fgetcsv($file, 1000000, ",")) !== FALSE) {
  
                $num = count($filedata);

                if($num != $no_trx){
                    return response()->json([
                        'success' => false,
                        'message' => "Only ".$num." records have been uploaded out of a total of ".$no_trx." indicated. Please retry again."
                    ]); 
                }
                // dd($num);
                // Skip first row (Remove below comment if you want to skip the first row)
                // if ($i == 0) {
                //     $i++;
                //     continue;
                // }
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file); //Close after reading
            $j = 0;
            foreach ($importData_arr as $importData) {
                // $name = $importData[1]; //Get user names
                // $email = $importData[3]; //Get the user emails
                $j++;
                try {
                    DB::beginTransaction();
                    Payout::create([
                        'credit_account' => $importData[0],
                        'amount' => $importData[1],
                        'currency' => $importData[2],
                        'status' => "Pending",
                        'userid' => Auth::user()->id,
                    ]);
                    //Send Email
                    // $this->sendEmail($email, $name);
                    DB::commit();
                } 
                catch (\Exception $e) {
                    //throw $th;
                    DB::rollBack();
                }
            }
            return response()->json([
                'success' => true,
                'message' => "$j records successfully uploaded"
            ]);
        } 
        else {
            //no file was uploaded
            throw new Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }
    public function checkUploadedFileProperties($extension, $fileSize){
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {

            } 
            else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        }
        else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }

    public function submit_checked(Request $request){
        $count = count($request->input('checked'));
        for ($i=0; $i<$count; $i++){
            $data[] = array('credit_account' => $request->input('credit_account')[$i],'amount' => $request->input('amount')[$i], 'currency' => $request->input('currency')[$i]);
        }
        
        $initialize = new __init__;
        $excel = $initialize->imported_data($data);
        return $excel;
    }

    public function todayDate(){
        Carbon::setLocale('fr');
        $todayDate = Carbon::now()->format('Y-m-d H:i:s');
        return $todayDate;
    }

    public function merchant_ref($prefix) {
        $length = 13;
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = $prefix;
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function paiementMultiple(Request $request){
        $convert = explode(",",$request->ids);
        $rows = Payout::whereIn('id', $convert)->get();
        
     
        foreach($rows as $idx => $row) {

            $ids = $row['id'];
            $customer_details = $row['credit_account'];
            $amount = $row['amount'];
            $currency = $row['currency'];

            $operator = $this->vendor($customer_details);

            if ($operator == null) {
                $data = [
                    'customer_details' => $customer_details,
                    'amount' => $amount,
                    'currency' => $currency,
                    'created_at' => $this->todayDate(),
                    'error' => "Number is incorrect",
                    'userid' => Auth::user()->id
                ];
                $store = DB::table('errors')->insert($data);
                if ($store) {
                    $transaction=payout::find($ids);
                    $transaction->delete();
                }
            }
            else {

                $url = 'https://paydrc.gofreshbakery.net/api/v5/';

                $merchant_info = User::where('id', Auth::user()->id)->first();
           
                $curl_post_data = [
                    "merchant_id" => $merchant_info->merchant_id,
                    "merchant_secrete"=> $merchant_info->merchant_secrete,
                    "action"=> "credit",
                    "method" => $operator,
                    "amount" => $amount,
                    "currency" => $currency,
                    "customer_number" => $customer_details,
                    "firstname" =>$merchant_info->firstname,
                    "lastname" => $merchant_info->lastname,
                    "email" => $merchant_info->email,
                    "reference" => $row['reference'],
                    "callback_url" => "https://phplaravel-900404-3126347.cloudwaysapps.com/api/v1/bulkpayment"
                ];

                $data = json_encode($curl_post_data);
                $ch=curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                $curl_response = curl_exec($ch);
                
                if ($curl_response == false) {
                    $message = "Erreur de connexion! Vérifiez votre connexion internet";
                    Alert::error('Erreur', $message);
                    return back();
                }
                else{
                    $curl_decoded = json_decode($curl_response,true);
                    if ($curl_decoded != null) {
                        $status = $curl_decoded['Status'];
                        if ($status == "Success") {
                            $comment = $curl_decoded['Comment'];
                            $customer_number = $curl_decoded['Customer_Number'];
                            $paydrc_reference = $curl_decoded['Transaction_id'];
                            $reference = $curl_decoded['Reference'];
                            $created_at = $curl_decoded['Created_At'];
                            $updated_at = $curl_decoded['Updated_At'];
                            $save = DB::table('mobile_money')->insert(
                            [
                                'customer_number' => $customer_number,
                                'amount' => $amount,
                                'currency' => $currency,
                                'comment' => $comment,
                                'action' => "credit",
                                'method' => $operator,
                                'status' => "Pending",
                                'reference' => $reference,
                                'transaction_id' => $paydrc_reference,
                                'user_id' => Auth::user()->id,
                                'created_at' => $created_at,
                                'updated_at' => $updated_at
                            ]
                            
                            );
                            if($save){
                                $transaction=payout::find($ids);
                                $transaction->delete();
                                Toastr::success('Transaction has been successfully submitted!', "Success");
                            }
                            else{
                                Toastr::error('Transaction envoyée avec succès :)','Error');
                                return redirect()->back();
                            }
                            
                        }
                        else {
                            Toastr::error($curl_decoded['Comment'],'Error');
                            return redirect()->route('caissier-transfert-emala-mobile-credit');
                        }
                    }
                    
                }

            }
        }
        return response()->json(['status'=>true,'message'=>"Payout successfully done! Please check logs status."]);
    }

    public function delete_payout(Request $request,$id)
    {
        $transaction=Payout::find($id);
        $transaction->delete();
        return back()->with('success','Transaction deleted successfully');
    }   
 
    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
    
        Payout::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['status'=>true,'message'=>"Transaction deleted successfully."]);
         
    }


    public function vendor($number = ''){
        $customer_number = $number;
        $len_number = strlen($number);
    
    
        if ($len_number == 9) {
            if (substr($customer_number, 0, 2) == '81' || substr($customer_number, 0, 2) == '82'  || substr($customer_number, 0, 2) == '83') {
                return 'mpesa';
            }
    
            if (substr($customer_number, 0, 2) == '99' || substr($customer_number, 0, 2) == '97') {
                return 'airtel';
            }
    
            if (substr($customer_number, 0, 2) == '85' || substr($customer_number, 0, 2) == '84' || substr($customer_number, 0, 2) == '89' || substr($customer_number, 0, 2) == '80') {
                return 'orange';
            }
        }
    
    
        if ($len_number == 10) {
            if (substr($customer_number, 0, 1) == '0') {
                if (substr($customer_number, 1, 2) == '81' || substr($customer_number, 1, 2) == '82' || substr($customer_number, 1, 2) == '83') {
                    return 'mpesa';
                }
            }
    
            if (substr($customer_number, 0, 1) == '0') {
                if (substr($customer_number, 1, 2) == '99' || substr($customer_number, 1, 2) == '97') {
                    return 'airtel';
                }
            }
    
            if (substr($customer_number, 0, 1) == '0') {
                if (substr($customer_number, 1, 2) == '85' || substr($customer_number, 1, 2) == '84' || substr($customer_number, 1, 2) == '89' || substr($customer_number, 1, 2) == '80') {
                    return 'orange';
                }
            }
    
        }
    
        if ($len_number == 12) {
            if (substr($customer_number, 0, 3) == '243') {
                if (substr($customer_number, 3, 2) == '81' || substr($customer_number, 3, 2) == '82' || substr($customer_number, 3, 2) == '83') {
                    return 'mpesa';
                }
    
                if (substr($customer_number, 3, 2) == '99' || substr($customer_number, 3, 2) == '97') {
                    return 'airtel';
                }
    
                if (substr($customer_number, 3, 2) == '85' || substr($customer_number, 3, 2) == '84' || substr($customer_number, 3, 2) == '89' || substr($customer_number, 3, 2) == '80') {
                    return 'orange';
                }
            }
    
        }
    
        if ($len_number < 9 || $len_number > 12) {
            return false;
        }
    
    }

    public function payoutAPI($credit_account, $amount, $currency){

           $operator = $this->vendor($credit_account);

            if ($operator == "mpesa") {
                $telephone = $this->vodacom($credit_account);
            }
            else {
                $telephone = $credit_account;
            }

           if ($operator == "mpesa") {

               $prefix = "BFINM";
               $apiURL = 'http://35.206.184.126:2801/api/v1/voda_fresh_payouts';
               $merchant_ref = $this->merchant_ref($prefix);
               $key = "oXc281OO9]AIl5.mZZ'#(c}j6rP,]E";
               $debit_account = "15120";
               $vendor = "vodacom";
   
           }
           elseif ($operator == "airtel") {

               $prefix = "FINA";
               $apiURL = 'http://35.205.213.194:2801/api/v1/airtel_fresh_payouts';
               $merchant_ref = $this->merchant_ref($prefix);
               $key = "oXc7119158]AIl5.mZZ'#(c}m6rP,Xi";
               $debit_account = "999500263";
               $vendor = "airtel";
           }
           elseif ($operator == "orange") {

               $prefix = "FINO";
               $apiURL = 'http://35.233.0.76:2801/api/v1/orange_fresh_payouts';
               $merchant_ref = $this->merchant_ref($prefix);
               $key = "oXc7119158]AIl5.mZZ'#(c}m6rP,Xi";
               $debit_account = "0858005724";
               $vendor = "orange";
           }
   
           $accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NDc0NDY0NjQsIm5iZiI6MTY0NzQ0NjQ2NCwianRpIjoiN2QxMThiMjEtODczZS00ZTBlLThjZjktYWRiYTc5ZDY4MDdhIiwiZXhwIjoxNjc4OTgyNDY0LCJpZGVudGl0eSI6IkZQMDA0IiwiZnJlc2giOmZhbHNlLCJ0eXBlIjoiYWNjZXNzIn0.bmQZL6iwop5VDA9bkp1oT-e4Qkh2aSxDVy7C9_VSsqQ";
     
           $headers = [
               'X-header' => 'Content-Type:application/json',
               'Authorization'  => 'Bearer '.$accessToken,
           ];
   
           $curl_post_data = [
               "credit_account" => $telephone,
               "amount" => $amount,
               "currency" => $currency,
               "action" => "payout",
               "debit_channel" => $vendor,
               "debit_account" => $debit_account,
               "merchant_ref" => $merchant_ref,
               "merchant_code" => "FP001",
               "key" => $key
           ];

            $response = Http::withHeaders($headers)->post($apiURL, $curl_post_data);
            $statusCode = $response->status();
            $responseBody = json_decode($response->getBody(), true);

            if ($statusCode == 200) {
                $response = [
                    'success' => true,
                    'status' => $responseBody['status'],
                    'amount' => $responseBody['amount'],
                    'currency' => $responseBody['currency'],
                    'financial_institution_transaction_id' => $responseBody['financial_institution_transaction_id'],
                    'trans_id' => $responseBody['trans_id'],
                    'transaction_status' => $responseBody['transaction_status'],
                    'created_at' => $responseBody['created_at'],
                    'debit_channel' => $responseBody['debit_channel'],
                    'destination_account' => $responseBody['destination_account'],
                ];
                return $response;
            }
            else {
                $response = [
                    'success' => false,
                    'message' => $responseBody['comment'],
                    'status' => $responseBody['status'],
                ];
                return $response;
            }

    }

    public function vodacom($number = ''){
        $inputPhone = $number;
        $len_number = strlen($number);
 
            if ($len_number == 9) {
                return '243'.$inputPhone;
            }

            if ($len_number == 10) {
                if (substr($inputPhone, 0, 1) == '0') {
                    return $inputPhone = '243'.substr($inputPhone, 1, $len_number);
                } elseif (substr($inputPhone, 0, 1) != '0') {
                    return false;
                }
            }

            if ($len_number < 9 || $len_number > 12) {
                return false;
            }

            if ($len_number == 12) {
                if (substr($inputPhone, 0, 3) != '243') {
                    return false;
                }
                return $inputPhone;
            }    
    }
}
