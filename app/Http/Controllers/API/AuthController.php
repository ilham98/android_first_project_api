<?php

namespace App\Http\Controllers\API;

use App\FirebaseMessageServiceToken;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function login(Request $request) {
        $key = $key = env('JWT_SECRET');
    
        $user = User::with('karyawan')->where(['npk' => $request->npk])->first();
        if($user) {
            $ldap_user = env('LDAP_USING_DEFAULT_ACCOUNT') ? 'utes2' : $request->npk;
            $ldap_password =  env('LDAP_USING_DEFAULT_ACCOUNT') ? 'PKTBONTANG77' : $request->password;
            $ldap_server = 'ldap://12.7.2.19';
            if(env('ldap') == false) {
                $isPasswordTrue = Hash::check($request->password, $user->password);
                // if($isPasswordTrue) {
                    $user->exp = time() + 60 * 30 * 24 * 30;
                    $jwt = JWT::encode($user, $key);
                    $user->access_token = $jwt;
                
                    return $user;
            } else {
                $ldap_conn = ldap_connect($ldap_server);
                $ldap_bind = @ldap_bind($ldap_conn, $ldap_user, $ldap_password);
                if($ldap_bind || env('ldap') == false) {
                    $isPasswordTrue = Hash::check($request->password, $user->password);
                    // if($isPasswordTrue) {
                        $user->exp = time() + 60 * 30 * 24 * 30;
                        $jwt = JWT::encode($user, $key);
                        $user->access_token = $jwt;
                    
                        return $user;
                    // }
                }
            }
            
        }

        return response(['error'] , 500);
    }

    public function logout(Request $request) {
        $user_id = $request->user_id;
        $fb = FirebaseMessageServiceToken::where('user_id', $user_id)->where('token', $request->token)->get();
        foreach($fb as $f) {
            $f->delete();
        }
        return response(['message' => 'success'], 200);
    }
}
