<?php

namespace App\Http\Controllers;


use Tymon\JWTAuth\Facades\JWTAuth;

class listasController extends Controller
{
    /**
     * @var
     */
    protected $user;

    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
}
