<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $user = User::where('npk', $request->npk)->first();
        if($user) {
            $ldap_user = env('LDAP_USING_DEFAULT_ACCOUNT') ? 'utes2' : $request->npk;
            $ldap_password =  env('LDAP_USING_DEFAULT_ACCOUNT') ? 'PKTBONTANG77' : $request->password;
            $ldap_server = 'ldap://12.7.2.19';
            $ldap_conn = ldap_connect($ldap_server);
            $ldap_bind = @ldap_bind($ldap_conn, $ldap_user, $ldap_password);
            if($ldap_bind || env('ldap') == false) {
                Auth::login($user);
                if(!in_array(Auth::user()->role_id, [1,2])) {
                    Auth::logout();
                    return redirect(url('/login'))->with(['message' => 'Login Pada Web SM Aset TI hanya untuk admin dan rendal.']);
                }
                if (Auth::check()) {
                    return redirect(url('/'));
                } else {
                    return redirect(url()->previous())->with(['message' => 'NPK Atau Password Salah']);
                }
                
            }
        }
        return redirect(url()->previous())->with(['message' => 'NPK Atau Password Salah']);
    }
    
    public function logout() {
        Auth::logout();
        return redirect(url('login'));
    }
}
