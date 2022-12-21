<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class verifyNumberController extends Controller
{
    public function verify_number($number = ''){
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
