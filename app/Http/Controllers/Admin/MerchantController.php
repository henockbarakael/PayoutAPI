<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function merchantList(){
        $user = User::all();
        return view('admin.user.all', compact('user'));
    }
}
