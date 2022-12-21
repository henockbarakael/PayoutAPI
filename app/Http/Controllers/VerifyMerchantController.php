<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifyMerchantController extends Controller
{
    public function verify_merchant($merchant_code = null) {
        $select = DB::table('merchants')->where('merchant_code', $merchant_code)->first();
        if ($select == null) {
           return false;
        }
        else {
            return true;
        }
    }

    public function verify_institution($institution_code = null) {
        $select = DB::table('institutions')->where('institution_code', $institution_code)->first();
        if ($select == null) {
           return false;
        }
        else {
            return true;
        }
    }

    public function verify_account($account_code = null) {
        $select = DB::table('accounts')->where('account_code', $account_code)->first();
        if ($select == null) {
           return false;
        }
        else {
            return true;
        }
    }
}
