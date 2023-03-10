<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\generateIDController;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr as FacadesToastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                FacadesToastr::error('Old Password Doesn\'t match!','Error');
            }

            #Update the new Password
            User::where('id', $request->user_id)->update([
                'password' => Hash::make($request->password),
                'salt' => $request->password,
                'updated_at' => $this->todayDate()
            ]);

            FacadesToastr::success('Password changed successfully!','Success');
            return redirect()->route('admin.merchant.list');

            // return response()->json(['success' => true,'message' => "Password changed successfully!"]);
    }

    public function todayDate(){
        Carbon::setLocale('fr');
        $todayDate = Carbon::now()->format('Y-m-d H:i:s');
        return $todayDate;
    }

    public function addUser(Request $request){
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
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
            'firstname' => $users->firstname,
            'lastname' => $users->lastname,
            'email' => $users->email,
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
        FacadesToastr::success('Create new account successfully :)','Success');
        return redirect()->route('admin.merchant.user.list');

    }
}