<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile(){
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.user.profile', compact('user'));
    }

    public function edit_profile(){
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.user.edit_profile', compact('user'));
    }
}
