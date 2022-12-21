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
            'firstname'  => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'role_name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password'  => 'required|string|min:8',
        ]);

        $date       = Carbon::now();
        $todayDate  = $date->toDayDateTimeString();

        $generateID = new generateIDController;
        $password = $generateID->password();
        $username = $generateID->username($data['firstname'],$data['lastname']);

        if ($data['role_name'] == "Admin") {
            $niveau = "0";
        }

        elseif ($data['role_name'] == "Super Admin") {
            $niveau = "1";
        }

        elseif ($data['role_name'] == "Support") {
            $niveau = "2";
        }

        User::create([
            'username' => $username,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
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
