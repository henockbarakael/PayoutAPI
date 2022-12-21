<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\generateIDController;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UsermanagementController extends Controller
{
    public function merchant_form(){
        return view('admin.merchant.add');
    }

    public function list_merchant(){
        $merchants = DB::table('airtime_merchant')->orderBy('id','desc')->get();
        return view('admin.merchant.all', compact('merchants'));
    }

    public function user_form(){
        $role   = DB::table('role_type_users')->get();
        $status_user = DB::table('user_types')->get();
        return view('admin.user.add', compact('role','status_user'));
    }

    public function add_user(Request $request){
        $request->validate([
            'firstname'  => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'role_name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);
        DB::beginTransaction();
        try{
            $dt       = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();

            $generateID = new generateIDController;
            $password = $generateID->password();
            $username = $generateID->username($request->firstname,$request->lastname);
            $user = new User;
            $user->username     = $username;
            $user->firstname    = $request->firstname;
            $user->lastname     = $request->lastname;
            $user->role_name    = $request->role_name;
            $user->status       = $request->status;
            $user->avatar       = "user.png";
            $user->salt         = $password;
            $user->password     = Hash::make($password);
            $user->created_at   = $todayDate;
            $user->updated_at   = $todayDate;
            $user->save();
            DB::commit();
            Toastr::success('Create new account successfully :)','Success');
            return redirect()->route('admin.user.list');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User add new account fail :)','Error');
            return redirect()->back();
        }
    }

    public function list_user(){
        $users = DB::table('users')->orderBy('id','desc')->get();
        return view('admin.user.all', compact('users'));
    }

    public function add_merchant(Request $request){
        $request->validate([
            'name'  => 'required|string|max:255',
            'email'  => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'merchant_code' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'comission' => 'required|string|max:255',
            'recruter' => 'required|string|max:255',
        ]);
        
        $apiURL = 'http://127.0.0.1:2801/api/v1/agent/create';
 
        $headers = [
            'X-header' => 'Content-Type:application/json'
        ];

        $curl_post_data = [
            "merchant_name" => $request->name,
            "merchant_email"=> $request->email,
            "merchant_phone" => $request->phone,
            "merchant_code" => $request->merchant_code,
            "merchant_user_firstname"=> $request->firstname,
            "merchant_user_lastname"=>$request->lastname,
            "merchant_comission" =>$request->comission,
            "merchant_recruter" =>$request->recruter
       ];

       $curl_comission = [
        "merchant_code" => $request->merchant_code,
        "comission" =>$request->comission
        ];
  
        $response = Http::withHeaders($headers)->post($apiURL, $curl_post_data);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        if ($statusCode == 200) {
            DB::table('airtime_comission')->insert($curl_comission);
            Toastr::success('Create new account successfully :)','Success');
            return redirect()->route('admin.merchant.list'); 
        }

        else {
           $err = $responseBody['resultData']['resultCodeErrorDescription'];
           Toastr::error($err,'Erreur');
           return redirect()->back();
        }

    }
}
