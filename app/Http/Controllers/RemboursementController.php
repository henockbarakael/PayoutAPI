<?php

namespace App\Http\Controllers;

use App\Imports\RemboursementImport;
use App\Models\Remboursement;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class RemboursementController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 1200);
    }

    public function remboursement(){
        $remboursements = DB::table('remboursements')->where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('admin.payout.remboursement', compact('remboursements'));
    }
    public function remboursement_logs(){
        $logs = DB::table('remboursement_logs')->where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('admin.payout.remboursement_logs', compact('logs'));
    }
    public function process_remboursement(Request $request){

        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx,xls',
        ]);

        $file = $request->file('file')->store('import');


        $import = new RemboursementImport;
        $import->import($file);

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        Toastr::success("Records successful imported!",'Success');
        return back()->withStatus('Import in queue, we will send notification after import finished.');

    }
    public function todayDate(){
        Carbon::setLocale('fr');
        $todayDate = Carbon::now()->format('Y-m-d H:i:s');
        return $todayDate;
    }
    public function delete_remboursement($id)
    {
        $transaction=Remboursement::find($id);
        $transaction->delete();
        return back()->with('success','Transaction deleted successfully');
    }
    public function remboursementID($id){
        $payouts = DB::table('remboursements')->where('user_id', Auth::user()->id)->where('id',$id)->first();

        $credit_account = $payouts->credit_account;
        $amount = $payouts->amount;
        $currency = $payouts->currency;

        $response = $this->payoutAPI($credit_account, $amount, $currency);

        if ($response['status'] == "Successful") {

            $data = [
                'amount' => $response['amount'],
                'currency' => $response['currency'],
                'status' => $response['status'],
                'financial_institution_transaction_id' => $response['financial_institution_transaction_id'],
                'trans_id' => $response['trans_id'],
                'transaction_status' => $response['transaction_status'],
                'created_at' => $response['created_at'],
                'debit_channel' => $response['debit_channel'],
                'destination_account' => $response['destination_account'],
                'user_id' => Auth::user()->id,
            ];
        
            DB::table('payout_logs')->insert($data);

            $transaction=Remboursement::find($id);
            $delete = $transaction->delete();
            if ($delete) {
                // Alert::success('Success', "Transaction has been successfully submitted!");
                Toastr::success('Transaction has been successfully submitted!', "Success");
                return back(); 
            }
            
        }
        elseif ($response['status'] == "Pending") {
            $data = [
                'amount' => $response['amount'],
                'currency' => $response['currency'],
                'status' => $response['status'],
                'financial_institution_transaction_id' => $response['financial_institution_transaction_id'],
                'trans_id' => $response['trans_id'],
                'transaction_status' => $response['transaction_status'],
                'created_at' => $response['created_at'],
                'debit_channel' => $response['debit_channel'],
                'destination_account' => $response['destination_account'],
                'user_id' => Auth::user()->id,
            ];
        
            DB::table('payout_logs')->insert($data);
            $transaction=Remboursement::find($id);
            $delete = $transaction->delete();
            if ($delete) {
                // Alert::success('Success', "Transaction pending!");
                Toastr::success('Transaction pending!', "Success");
                return back(); 
            }
        }
        elseif($response['status'] == "Failed") {
            $data = [
                'amount' => $response['amount'],
                'currency' => $response['currency'],
                'status' => $response['status'],
                'financial_institution_transaction_id' => $response['financial_institution_transaction_id'],
                'trans_id' => $response['trans_id'],
                'transaction_status' => $response['transaction_status'],
                'created_at' => $response['created_at'],
                'debit_channel' => $response['debit_channel'],
                'destination_account' => $response['destination_account'],
                'user_id' => Auth::user()->id,
            ];
        
            DB::table('payout_logs')->insert($data);
            $transaction=Remboursement::find($id);
            $delete = $transaction->delete();
            if ($delete) {
                Alert::success('Success', "Transaction Failed!");
                Toastr::error('Transaction Failed!', "Error");

                return back(); 
            }
        }

    }
    public function merchant_ref($prefix) {
        $length = 8;
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
        $rows = Remboursement::whereIn('id', $convert)->get();
        foreach($rows as $idx => $row) {

            $ids = $row['id'];
            $credit_account = $row['customer_details'];
            $amount = $row['amount'];
            $currency = $row['currency'];
            $paydrc_reference = $row['paydrc_reference'];
            $action = $row['action'];
            $method = $row['method'];

            $operator = $this->vendor($credit_account);

            if ($operator == null) {
                $data = [
                    'customer_details' => $credit_account,
                    'amount' => $amount,
                    'currency' => $currency,
                    'created_at' => $this->todayDate(),
                    'error' => "Number is incorrect",
                    'user_id' => Auth::user()->id
                ];
                $store = DB::table('errors')->insert($data);
                if ($store) {
                    $transaction=Remboursement::find($ids);
                    $transaction->delete();
                }
            }
            else {
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
               if ($operator == "airtel") {
    
                   $prefix = "FINA";
                   $apiURL = 'http://35.205.213.194:2801/api/v1/airtel_fresh_payouts';
                   $merchant_ref = $this->merchant_ref($prefix);
                   $key = "oXc7119158]AIl5.mZZ'#(c}m6rP,Xi";
                   $debit_account = "999500263";
                   $vendor = "airtel";
               }
               if ($operator == "orange") {
    
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
                        $data = [
                                'amount' => $response['amount'],
                                'currency' => $response['currency'],
                                'merchant_ref' => $merchant_ref,
                                'status' => $response['status'],
                                'financial_institution_transaction_id' => $response['financial_institution_transaction_id'],
                                'trans_id' => $response['trans_id'],
                                'transaction_status' => $response['transaction_status'],
                                'created_at' => $response['created_at'],
                                'debit_channel' => $response['debit_channel'],
                                'destination_account' => $response['destination_account'],
                                'paydrc_reference' => $paydrc_reference,
                                'action' => $action,
                                'user_id' => Auth::user()->id
                        ];
                        $store = DB::table('remboursement_logs')->insert($data);
                        if ($store) {
                            $transaction=Remboursement::find($ids);
                            $transaction->delete();
                            Toastr::success('Transaction has been successfully submitted!', "Success");
                        }

                    }
                    else {
                        Toastr::error('Transaction failed!', "Error");
                    }
            }
        
           

        }
        return response()->json(['status'=>true,'message'=>"Payout successfully done! Please check logs status."]);
    }
    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
    
        Remboursement::whereIn('id',explode(",",$ids))->delete();
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
}
