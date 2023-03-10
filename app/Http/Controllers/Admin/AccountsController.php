<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{
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
                return response()->json(['success' => false,'message' => "Old Password Doesn't match!"]);
            }

            #Update the new Password
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->password),
                'salt' => $request->password,
                'updated_at' => $this->todayDate()
            ]);

            return response()->json(['success' => true,'message' => "Password changed successfully!"]);
    }

    public function todayDate(){
        Carbon::setLocale('fr');
        $todayDate = Carbon::now()->format('Y-m-d H:i:s');
        return $todayDate;
    }
}
