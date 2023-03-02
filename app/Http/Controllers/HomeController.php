<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin()
    {
        $file_imported = DB::table('payouts')->where('userid', Auth::user()->id)->count();
        $log_success = DB::table('payout_logs')->whereDate('created_at', Carbon::today()->toDateString())->where('userid', Auth::user()->id)->where('status','Successful')->count();
        $log_pending = DB::table('payout_logs')->whereDate('created_at', Carbon::today()->toDateString())->where('userid', Auth::user()->id)->where('status','Pending')->count();
        $log_failed = DB::table('payout_logs')->whereDate('created_at', Carbon::today()->toDateString())->where('userid', Auth::user()->id)->where('status','Failed')->count();
        return view('admin.dashboard', compact('file_imported','log_success','log_pending','log_failed'));
    }
    public function merchant()
    {
        $merchant_info = User::where('id', Auth::user()->id)->first();

        $data = [
            "merchant_code" => $merchant_info->merchant_code,
        ];
        
        $sendData = Http::post('http://206.189.25.253/merchants/merchant-wallet', $data);
        $transactions = $sendData->json();

        // $airtel_cdf = 0;
        // dd($transactions);
        foreach ($transactions as $key => $value) {
            if ($value["vendor"] == "airtel" && $value["currency"] == "CDF") {
                $airtel_cdf = $value["amount"];
            }
            elseif ($value["vendor"] == "airtel" && $value["currency"] == "USD") {
                $airtel_usd = $value["amount"];
            }
            elseif ($value["vendor"] == "orange" && $value["currency"] == "CDF") {
                $orange_cdf = $value["amount"];
            }
            elseif ($value["vendor"] == "orange" && $value["currency"] == "USD") {
                $orange_usd = $value["amount"];
            }
            elseif ($value["vendor"] == "vodacom" && $value["currency"] == "CDF") {
                $vodacom_cdf = $value["amount"];
            }
            elseif ($value["vendor"] == "vodacom" && $value["currency"] == "USD") {
                $vodacom_usd = $value["amount"];
            }
        }

        // dd($orange_cdf);
        
        $file_imported = DB::table('payouts')->where('userid', Auth::user()->id)->count();
        $log_success = DB::table('payout_logs')->whereDate('created_at', Carbon::today()->toDateString())->where('userid', Auth::user()->id)->where('status','Successful')->count();
        $log_pending = DB::table('payout_logs')->whereDate('created_at', Carbon::today()->toDateString())->where('userid', Auth::user()->id)->where('status','Pending')->count();
        $log_failed = DB::table('payout_logs')->whereDate('created_at', Carbon::today()->toDateString())->where('userid', Auth::user()->id)->where('status','Failed')->count();
        return view('merchant.dashboard', compact(
            'file_imported','log_success','log_pending','log_failed',
            'vodacom_usd','vodacom_cdf',
            'orange_usd','orange_cdf',
            'airtel_usd','airtel_cdf'
        ));
    }

    public function index()
    {
        return view('home');
    }
}
