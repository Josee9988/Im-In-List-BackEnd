<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class protectedUserNullController extends Controller
{
    /**
     * @var
     */
    protected $user;

    /**
     * __construct
     * Summary: Controla si el usuario tiene token o no
     *
     * @return void
     */
    public function __construct()
    {
        try {
            $this->user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            $this->user = null;
        }
    }
}
