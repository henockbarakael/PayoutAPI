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
        Callback::insert(["data" =>$data]);
        $result = json_decode($request->getContent(),true);
     

        $dataToSend =  [
            "status" => $result['status'],
            "telco_reference" => $result['telco_reference'],
            "switch_reference" => $result['switch_reference'],
            "paydrc_reference" => $result['paydrc_reference'],
            "action" => $result['action'],
            "telco_status_description" => $result['telco_status_description'],
        ];

        
        // Callback::insert(["data" =>$result]);
        CallbackData::insert($dataToSend);
    }
}
