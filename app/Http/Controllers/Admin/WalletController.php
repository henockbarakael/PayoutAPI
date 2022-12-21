<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallet = DB::table('airtime_wallet')->orderBy('id','desc')->get();
        return view('admin.wallet.add', compact('wallet'));
    }

    public function list_wallet()
    {
        $wallet = DB::table('airtime_wallet')
        ->join('airtime_account','airtime_wallet.account_id','airtime_account.account_id')
        ->select('airtime_wallet.*','airtime_account.merchant_code')
        ->orderBy('airtime_wallet.id','desc')->get();
        return view('admin.wallet.all', compact('wallet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'wallet_code'  => 'required|string|max:255',
            'amount'  => 'required|string|max:255',
            'method' => 'required|string|max:255',
        ]);

        $apiURL = 'http://127.0.0.1:2801/api/v1/superagent/wallet/topup';
 
        $headers = [
            'X-header' => 'Content-Type:application/json'
        ];

        $curl_post_data = [
            "wallet_code" => $request->wallet_code,
            "amount"=> $request->amount,
            "method" => $request->method,
       ];

       $response = Http::withHeaders($headers)->post($apiURL, $curl_post_data);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        if ($statusCode == 200) {
            Toastr::success('Wallet Top-Up successfully :)','Success');
            return redirect()->route('admin.wallet.list'); 
        }

        else {
           $err = $responseBody['resultCodeErrorDescription'];
           Toastr::error($err,'Erreur');
           return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
