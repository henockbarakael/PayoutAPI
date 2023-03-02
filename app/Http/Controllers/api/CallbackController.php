<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CallbackResponse;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function getCallbackResponse(Request $request){

        $dataToSend =  [
            "status" => $request->Status,
            "comment" => $request->Comment,
            "trans_status" => $request->Trans_Status,
            "currency" => $request->Currency,
            "amount" => $request->Amount,
            "method" => $request->Method,
            "customer_details" => $request->Customer_Details,
            "reference" => $request->Reference,
            "paydrc_reference" => $request->PayDRC_Reference,
            "action" => $request->Action,
            "status_description" => $request->Status_Description,
            "trans_status_description" => $request->Trans_Status_Description
        ];

        CallbackResponse::create($dataToSend);
    }
}