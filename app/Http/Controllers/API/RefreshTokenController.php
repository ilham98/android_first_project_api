<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Firebase\JWT\JWT;

class RefreshTokenController extends Controller
{
    public function refresh() {
        $key = env('JWT_SECRET');
        $payload = array(
            "type" => 'access_token',
            "exp" => time() + 60 * 30
        );

        $payload_refresh = array(
            "type" => 'refresh_token',
            "exp" => time() + 60 * 60 * 24 * 30
        );

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
        $jwt = JWT::encode($payload, $key);

        $jwt_refresh = JWT::encode($payload_refresh, $key);

        return ['access_token' => $jwt, 'refresh_token' => $jwt_refresh];
    }
}
