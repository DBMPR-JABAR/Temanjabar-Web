<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class JwtMiddleware
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
        $response = [
            'status' => 'false',
            'data' => []
        ];
        $code = 200;

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $response['data']['message'] = 'Token is Invalid';
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $response['data']['message'] = 'Token is Expired';
            }else{
                $response['data']['message'] = 'Authorization Token not found';
                $code = 500;
            }
            return response()->json($response, $code);
        }

        return $next($request);
    }
}
