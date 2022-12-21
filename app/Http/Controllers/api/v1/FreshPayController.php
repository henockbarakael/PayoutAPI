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

        return response()->json([ 'credit_account' => $request->credit_account, 'amount' => $request->amount, 'currency' => $request->currency, ]);

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
