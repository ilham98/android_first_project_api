<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $user = User::where(['npk' => $request->npk])->first();
        if($user) {
            $isPasswordTrue = Hash::check($request->password, $user->password);
            if($isPasswordTrue) {
                return $user;
            }
        }

        return response(['error'] , 500);
    }
}
