<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr as FacadesToastr;
use Brian2694\Toastr\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    public function merchantList(){
        $users = User::all();
        return view('admin.user.all', compact('users'));
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
            return redirect()->back();

            // return response()->json(['success' => true,'message' => "Password changed successfully!"]);
    }

    public function todayDate(){
        Carbon::setLocale('fr');
        $todayDate = Carbon::now()->format('Y-m-d H:i:s');
        return $todayDate;
    }
}
