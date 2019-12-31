<?php

namespace App\Http\Middleware;
use \Firebase\JWT\JWT;

use Closure;

class TokenCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $token = $request->header('access_token');
        $key = env('JWT_SECRET');
        try {
            $decoded = JWT::decode($token, $key, array('HS256'));
        } catch (\Exception $e) {
            return response(['messages' => 'your token is wrong or expired'], 500);
        }


        $request->user_id = $decoded->id;
        $request->user_role_id = $decoded->role_id;
        $request->user_npk = $decoded->npk;
        return $next($request);
    }
}
