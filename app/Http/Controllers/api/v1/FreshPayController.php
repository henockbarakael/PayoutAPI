<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class FreshPayController extends Controller
{
    public function payout(Request $request){

        // $response = [
        //     'success' => true,
        //     'message' => "Successful",
        //     'status' => "Success",
        // ];

        // return $response;
        return response()->json([ 'credit_account' => $request->credit_account, 'amount' => $request->amount, 'currency' => $request->currency, ]);
        // $validator = Validator::make($request->all(), [
        //     'credit_account'  => 'required',
        //     'amount'  => 'required',
        //     'currency'  => 'required',
        // ]);

        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());       
        // }

        // $todayDate = $this->todayDate();
   
        // $operator = $this->vendor($request->credit_account);

        // if ($operator == "mpesa") {
        //     $prefix = "M";
        //     $apiURL = 'http://35.206.184.126:2801/api/v1/voda_fresh_payouts';
        //     $merchant_ref = $this->merchant_ref($prefix);
        //     $key = "oXc281OO9]AIl5.mZZ'#(c}j6rP,]E";
        //     $debit_account = "15120";
        //     $vendor = "vodacom";

        // }
        // elseif ($operator == "airtel") {
        //     $prefix = "A";
        //     $apiURL = 'http://35.205.213.194:2801/api/v1/airtel_fresh_payouts';
        //     $merchant_ref = $this->merchant_ref($prefix);
        //     $key = "oXc7119158]AIl5.mZZ'#(c}m6rP,Xi";
        //     $debit_account = "999500263";
        //     $vendor = "airtel";
        // }
        // elseif ($operator == "orange") {
        //     $prefix = "O";
        //     $apiURL = 'http://35.233.0.76:2801/api/v1/orange_fresh_payouts';
        //     $merchant_ref = $this->merchant_ref($prefix);
        //     $key = "oXc7119158]AIl5.mZZ'#(c}m6rP,Xi";
        //     $debit_account = "0858005724";
        //     $vendor = "orange";
        // }

        // $accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NDc0NDY0NjQsIm5iZiI6MTY0NzQ0NjQ2NCwianRpIjoiN2QxMThiMjEtODczZS00ZTBlLThjZjktYWRiYTc5ZDY4MDdhIiwiZXhwIjoxNjc4OTgyNDY0LCJpZGVudGl0eSI6IkZQMDA0IiwiZnJlc2giOmZhbHNlLCJ0eXBlIjoiYWNjZXNzIn0.bmQZL6iwop5VDA9bkp1oT-e4Qkh2aSxDVy7C9_VSsqQ";
  
        // $headers = [
        //     'X-header' => 'Content-Type:application/json',
        //     'Authorization'  => 'Bearer '.$accessToken,
        // ];

        // $curl_post_data = [
        //     "credit_account" => $request->credit_account,
        //     "amount" => $request->amount,
        //     "currency" => $request->currency,
        //     "action" => "payout",
        //     "debit_channel" => $vendor,
        //     "debit_account" => $debit_account,
        //     "merchant_ref" => $merchant_ref,
        //     "merchant_code" => "FP001",
        //     "key" => $key
        // ];

        //  $response = Http::withHeaders($headers)->post($apiURL, $curl_post_data);
        //  $statusCode = $response->status();
        //  $responseBody = json_decode($response->getBody(), true);
        //  if ($statusCode == 200) {
        //      $response = [
        //          'success' => true,
        //          'message' => $responseBody['comment'],
        //          'status' => $responseBody['status'],
        //      ];
        //      return $response;
        //  }
        //  else {
        //      $response = [
        //          'success' => false,
        //          'message' => $responseBody['comment'],
        //          'status' => $responseBody['status'],
        //      ];
        //      return $response;
        //  }
    }

    public function todayDate(){
        Carbon::setLocale('fr');
        $todayDate = Carbon::now()->format('Y-m-d H:i:s');
        return $todayDate;
    }

    public function vendor($number = '')
    {
        $customer_number = $number;
        $len_number = strlen($number);
    
    
        if ($len_number == 9) {
            if (substr($customer_number, 0, 2) == '81' || substr($customer_number, 0, 2) == '82') {
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
                if (substr($customer_number, 1, 2) == '81' || substr($customer_number, 1, 2) == '82') {
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
                if (substr($customer_number, 3, 2) == '81' || substr($customer_number, 3, 2) == '82') {
                    return 'mpesa';
                }
    
                if (substr($customer_number, 3, 2) == '99' || substr($customer_number, 3, 2) == '97') {
                    return 'airtel';
                }
    
                if (substr($customer_number, 3, 2) == '85' || substr($customer_number, 3, 2) == '84' || substr($customer_number, 3, 2) == '89' && substr($customer_number, 3, 2) == '80') {
                    return 'orange';
                }
            }
    
        }
    
        if ($len_number < 9 || $len_number > 12) {
            return false;
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
}
