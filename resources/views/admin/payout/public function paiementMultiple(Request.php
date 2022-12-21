public function paiementMultiple(Request $request)
{

    $j = count(array($request->ids));
    for($i = 0; $i < $j ; $i++) {
        $payouts = DB::table('payouts')->select('id','credit_account','amount','currency')->where('id',$j)->get();
        var_dump($payouts);
    }
    $ids = array($request->ids);

    dd(count($ids));

    for ( $i=0; $i < count($ids) ; $i++ ){
        dd($i++);
    }
        
    dd($ids);
    foreach ($ids as $key => $value) {
        dd($value);
    }
    $string="";
    foreach ($ids as  $key => $val) {
        dd($val);
    // $string .= ',' .$val['credit_account'];
    }
    dd($string);

    $string = substr($string,1);
    $string = explode(',',$string);


    
    
    dd($ids);
        for ( $i=0; $i < count( array($ids) ); $i++ )
        {

            
            // do some stuff, save to database, etc.
            $payouts = DB::table('payouts')->select('id','credit_account','amount','currency')->where('id',$ids)->get();
            
            $credit_account = $payouts[0]->credit_account;
            $amount = $payouts[0]->amount;
            $currency = $payouts[0]->currency;
            $id = $payouts[0]->id;
            
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
                ];
            
                DB::table('payout_logs')->insert($data);
    
                $transaction=Payout::find($id);
                $delete = $transaction->delete();
                if ($delete) {
                    return response()->json(['status'=>true,'message'=>"Category deleted successfully."]);
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
                ];
            
                DB::table('payout_logs')->insert($data);
                $transaction=Payout::find($id);
                $delete = $transaction->delete();
                if ($delete) {
                    return response()->json(['status'=>true,'message'=>"Category deleted successfully."]);
                }
            }
            else {
                return response()->json(['status'=>false,'message'=>"Category deleted successfully."]);
            }
    
        }
        


    
     
}