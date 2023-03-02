<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Callback;
use App\Models\CallbackData;
use Illuminate\Http\Request;

class FreshPayController extends Controller
{
    public function getCallbackResponse(Request $request){
        // dd('test du callback');
        $data = $request->getContent();
        $result = json_decode($data, true);
     

        $dataToSend =  [
            "status" => $result['Status'],
            "telco_reference" => $result['telco_reference'],
            "switch_reference" => $result['switch_reference'],
            "paydrc_reference" => $result['PayDRC_Reference'],
            "action" => $result['action'],
            "telco_status_description" => $result['telco_status_description'],
        ];

        CallbackData::insert($dataToSend);
    }
}
