<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function index()
    {
        return view('home');
    }
}
