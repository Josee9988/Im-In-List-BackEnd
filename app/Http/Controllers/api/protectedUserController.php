<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class protectedUserController extends Controller
{
    /**
     * @var
     */
    protected $user;

    /**
     * ListasController constructor.
     */
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
}
