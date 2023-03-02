<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\generateIDController;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function register()
    {
        $role = DB::table('role_type_users')->get();
        return view('auth.register', compact('role'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function storeUser(Request $request)
    {
        $data = $request->validate([
            'role_name'  => 'required|string|max:255',
            'merchant_code'  => 'required|string|max:255',
        ]);

        $date       = Carbon::now();
        $todayDate  = $date->toDayDateTimeString();

        $generateID = new generateIDController;
        $password = $generateID->password();

        if ($data['role_name'] == "Admin") {
            $niveau = "0";
        }

        elseif ($data['role_name'] == "Merchant") {
            $niveau = "1";
        }
        $merchant_code = $request->merchant_code;

        $response = Http::get('http://206.189.25.253/services/paydrc/merchant/<merchant_code>?', ["merchant_code"=>$merchant_code]);
        $result = $response->json();

        // dd($result);

        User::create([
            'merchant_id' => $result[0]['merchant_id'],
            'merchant_code' => $result[0]['merchant_code'],
            // 'merchant_secrete' => $result[0]['merchant_secrete'],
            'institution_code' => $result[0]['institution_code'],
            'institution_name' => $result[0]['institution_name'],
            'firstname' => $result[0]['firstname'],
            'lastname' => $result[0]['lastname'],
            'email' => $result[0]['email'],
            'salt'     => $password,
            'niveau'     => $niveau,
            'password' => Hash::make($password),
            'avatar'   => "user.png",
            'user_status' => 'Hors ligne',
            'status' => 'Active',
            'role_name' => $data['role_name'],
            'created_at'   => $todayDate,
            'updated_at'   => $todayDate,
        ]);
        Toastr::success('Create new account successfully :)','Success');
        return redirect('login');
    }
}
