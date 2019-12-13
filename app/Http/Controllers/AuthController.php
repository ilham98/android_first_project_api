<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        Auth::attempt(['npk' => $request->npk, 'password' => $request->password]);
        if (Auth::check()) {
            return redirect(url('purchase-order'));
        } else
        return redirect(url()->previous());
    }
    
    public function logout() {
        Auth::logout();
        return redirect(url('login'));
    }
}
