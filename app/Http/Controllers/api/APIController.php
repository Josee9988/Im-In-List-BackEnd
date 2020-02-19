<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class APIController extends Controller
{
    /**
     * @var bool
     */
    //public $loginAfterSignUp = true;

    /**
     *  - R E G I S T E R
     * - Crea un usuario y le crea un token
     */
    public function register(Request $request)
    {
        $peticionUrl = file_get_contents($this->url . '?secret=' . $this->private_key . '&response=' . $request->captcha);
        $estadoCaptcha = json_decode($peticionUrl)->success;

        if ($estadoCaptcha) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role = 1;
            $user->save();

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user', 'token'), 201);

        } else {
            return response()->json([
                'message' => 'Error, Actividad sospechosa',
            ]);
        }

    }

    /**
     *  - L O G I N
     * - Si email y password son correctos se genera el token
     */
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'message' => '- Error de login, password o email incorrectos',
            ], 401);
        }

        return response()->json([
            'token' => $token,
        ]);
    }

    /**
     *  - R E F R E S H
     */
    public function refreshToken()
    {
        $token = JWTAuth::getToken();

        try {
            $token = JWTAuth::refresh($token);
            return response()->json([
                'token' => $token,
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json([
                'message' => 'Vuelve al login',
            ], 422);
        }
    }

    /**
     *  - AUTHENTICATE
     */
    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['usuario no encontrado'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['Token_expirado']);

        } catch (TokenInvalidException $e) {

            return response()->json(['Token_invalido']);

        } catch (JWTException $e) {

            return response()->json(['token_absent']);

        }

        return response()->json(compact('user'));
    }

    /**
     *  - L O G O U T (FRONT)
     */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
        ]);

        if (JWTAuth::invalidate($request->token)) {
            return response()->json([
                'message' => 'User logged out successfully',
            ]);
            $request->token->delete();
        } else {

            return response()->json([
                'message' => 'Sorry, the user cannot be logged out',
            ], 500);
        }
    }

}
