<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Callback;
use App\Models\CallbackData;
use App\Models\MobileMoney;
use App\Models\Payout;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FreshPayController extends Controller
{
    public function getCallbackResponse(Request $request){
        // dd('test du callback');
        $data = $request->getContent();
        Callback::insert(["data" =>$data]);
        $result = json_decode($request->getContent(),true);

        if ($result != null) {
            $dataToSend =  [
                "status" => $result['status'],
                "telco_reference" => $result['telco_reference'],
                "switch_reference" => $result['switch_reference'],
                "paydrc_reference" => $result['paydrc_reference'],
                "action" => $result['action'],
                "telco_status_description" => $result['telco_status_description'],
            ];
            $save = CallbackData::insert($dataToSend);
            if ($save) {
                MobileMoney::where('transaction_id',$result['paydrc_reference'])->update(['status' => $result['status'],'updated_at' => $this->todayDate()]);
            }
            
        }

     
        
    }
    public function todayDate(){
        Carbon::setLocale('fr');
        $todayDate = Carbon::now()->format('Y-m-d H:i:s');
        return $todayDate;
    }
}
