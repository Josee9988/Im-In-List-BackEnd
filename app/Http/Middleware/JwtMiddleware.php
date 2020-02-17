<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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

        try {
            $user = JWTAuth::parseToken()->authenticate();

        } catch (Exception $e) {
            
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token invalido'], 401);
            }

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status' => 'Token expirado'], 401);
            }

            if ($e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
                return response()->json(['status' => 'Token inexistente'], 401);
            }

            

        }
        return $next($request);
    }
}
