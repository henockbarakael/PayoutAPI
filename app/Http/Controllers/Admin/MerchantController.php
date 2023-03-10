<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\generateIDController;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    public function merchantList(){
        $users = User::all();
        return view('admin.user.all', compact('users'));
    }

    public function merchantUser(){
        $users = DB::table('users')->select('institution_name')->get();
        return view('admin.user.merchant', compact('users'));
    }

    public function updatePassword(Request $request)
    {
            # Validation

            $validator = Validator::make($request->all(), [
                'old_password' => 'required|min:8',
                'password' => 'required|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false,'message' => $validator->errors()->all()]);
            }

            #Match The Old Password
            if(!Hash::check($request->old_password, auth()->user()->password)){
                Toastr::error('Old Password Doesn\'t match!','Error');
            }

            #Update the new Password
            User::where('id', $request->user_id)->update([
                'password' => Hash::make($request->password),
                'salt' => $request->password,
                'updated_at' => $this->todayDate()
            ]);

            Toastr::success('Password changed successfully!','Success');
            return redirect()->route('admin.merchant.list');

            // return response()->json(['success' => true,'message' => "Password changed successfully!"]);
    }

    public function todayDate(){
        Carbon::setLocale('fr');
        $todayDate = Carbon::now()->format('Y-m-d H:i:s');
        return $todayDate;
    }

    public function merchantAdd(Request $request){
        // dd($request->all());
        $request->validate([
            'merchant_code' => 'required|string|max:255',
            'merchant_secrete' => 'required|string|max:255',
            'avatar' => 'required|mimes:png,jpg,jpeg,svg|max:2048',
            'logo' => 'required|mimes:png,jpg,jpeg,svg|max:2048',
        ]);


        $avatar = time().'.'.$request->avatar->extension();  
        $logo = time().'.'.$request->logo->extension();  

        $request->avatar->move(public_path('assets/images/users'), $avatar);
        $request->logo->move(public_path('assets/images'), $logo);

        $date       = Carbon::now();
        $todayDate  = $date->toDayDateTimeString();

        $generateID = new generateIDController;
        $password = $generateID->password();

        $merchant_code = $request->merchant_code;

        $response = Http::get('http://206.189.25.253/services/paydrc/merchant/<merchant_code>?', ["merchant_code"=>$merchant_code]);
        $result = $response->json();

        User::create([
            'merchant_id' => $result[0]['merchant_id'],
            'merchant_code' => $request->merchant_code,
            'merchant_secrete' => $request->merchant_secrete,
            'institution_code' => $result[0]['institution_code'],
            'institution_name' => $result[0]['institution_name'],
            'firstname' => $result[0]['firstname'],
            'lastname' => $result[0]['lastname'],
            'email' => $result[0]['email'],
            'salt'     => $password,
            'niveau'     => "1",
            'password' => Hash::make($password),
            'avatar'   => $request->avatar,
            'logo'   => $request->logo,
            'user_status' => 'Hors ligne',
            'status' => 'Active',
            'role_name' => 'Merchant',
            'created_at'   => $todayDate,
            'updated_at'   => $todayDate,
        ]);

        Toastr::success('Create new account successfully :)','Success');
        return redirect()->route('admin.merchant.list');

    }

    public function addUser(Request $request){
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'institution_name' => 'required|string',
        ]);
        $users = DB::table('users')->where('institution_name',$request->institution_name)->first();
        $date       = Carbon::now();
        $todayDate  = $date->toDayDateTimeString();

        $generateID = new generateIDController;
        $password = $generateID->password();

        User::create([
            'merchant_id' => $users->merchant_id,
            'merchant_code' => $users->merchant_code,
            'merchant_secrete' => $users->merchant_secrete,
            'institution_code' => $users->institution_code,
            'institution_name' => $users->institution_name,
            'logo' => $users->logo,
            'avatar' => $users->avatar,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'salt'     => $password,
            'niveau'     => $users->niveau,
            'password' => Hash::make($password),
            'avatar'   => "user.png",
            'user_status' => 'Hors ligne',
            'status' => 'Active',
            'role_name' => $users->role_name,
            'created_at'   => $todayDate,
            'updated_at'   => $todayDate,
        ]);
        Toastr::success('Create new account successfully :)','Success');
        return redirect()->route('admin.merchant.user.list');

    }
}
