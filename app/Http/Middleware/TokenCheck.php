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
            if($decoded->type !== 'access_token')
                return response(['messages' => 'something went wrong'], 500);
        } catch (\Exception $e) {
            return response(['messages' => 'something went wrong'], 500);
        }

        return $next($request);
    }
}
