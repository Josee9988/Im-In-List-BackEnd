<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class protectedUserController extends Controller
{
    /**
     * @var
     */
    protected $user;

    /**
     * ListasController constructor.
     *  - Control del token del usuario
     */
    public function __construct()
    {
        try {
            $this->user = JWTAuth::parseToken()->authenticate();

        } catch (Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token invalido'], 401);
            }

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status' => 'Token expirado'], 401);
            }

            return response()->json(['status' => 'Token inexistente'], 401);

        }

    }
}
