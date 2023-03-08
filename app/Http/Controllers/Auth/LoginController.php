<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\verifyNumberController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo(){
        if( Auth()->user()->niveau == "0"){
            return redirect()->route('admin.dashboard');
        }
        elseif( Auth()->user()->niveau == "1"){
            return redirect()->route('merchant.dashboard');
        }
        elseif( Auth()->user()->niveau == "2"){
            return redirect()->route('submerchant.dashboard');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'firstname' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $date       = Carbon::now();
        $todayDate  = $date->toDayDateTimeString();
        $firstname = $request->firstname;;
        $password = $request->password;

        if (Auth::attempt(['firstname'=>$firstname,'password'=>$password])) {
            // dd('ok');
            if (Auth::user()->niveau == "0") {
                $stmt = DB::table('users')->where('firstname',$firstname)->first();
                $user_id = $stmt->id;
                $firstname = $stmt->firstname;
                $clientIP = request()->ip();
                $log = [
                    'user_id'  => $user_id,
                    'username'  => $firstname,
                    'description' => 'Connecté',
                    'date_time'   => $todayDate,
                    'ipadress'   => $clientIP,
                ];
                $user_status = [
                    'user_status' => 'En ligne',
                ];
                DB::table('activity_logs')->insert($log);
                DB::table('users')->where('id',$user_id)->update($user_status);
                Toastr::success('Login successfully :)','Succès');
                return redirect()->route('admin.dashboard');
            }
            elseif (Auth::user()->niveau == "1") {
                $stmt = DB::table('users')->where('firstname',$firstname)->first();
                $user_id = $stmt->id;
                $firstname = $stmt->firstname;
                $clientIP = request()->ip();
                $log = [
                    'user_id'  => $user_id,
                    'username'  => $firstname,
                    'description' => 'Connecté',
                    'date_time'   => $todayDate,
                    'ipadress'   => $clientIP,
                ];
                $user_status = [
                    'user_status' => 'En ligne',
                ];
                DB::table('activity_logs')->insert($log);
                DB::table('users')->where('id',$user_id)->update($user_status);
                Toastr::success('Login successfully :)','Succès');
                return redirect()->route('merchant.dashboard');
            }

        }
        else{
            Toastr::error('Echec, firstname ou mot de passe incorrect :)','Erreur');
            return redirect('login');
        }
    }

    public function logout()
    {
        $user = Auth::User();
        Session::put('users', $user);
        $user=Session::get('users');

        $user_id = $user->id;
        $username = $user->username;
        $clientIP = request()->ip();
        $dt         = Carbon::now();
        $todayDate  = $dt->toDayDateTimeString();

        $currentTime = Carbon::now();
        $date = $currentTime->toDateTimeString();

        $log = [
            'user_id'  => $user_id,
            'username'  => $username,
            'description' => 'Déconnecté',
            'date_time'   => $todayDate,
            'ipadress'   => $clientIP,
        ];

        $user_status = [
            'user_status' => 'Hors ligne',
        ];

        DB::table('activity_logs')->insert($log);
        DB::table('users')->where('id',$user_id)->update($user_status);
        Auth::logout();
        Toastr::success('Logout successfully :)','Success');
        return redirect('login');
    }
}
