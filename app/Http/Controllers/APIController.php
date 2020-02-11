<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class APIController extends Controller
{
    /**
     * @var bool
     */
    //public $loginAfterSignUp = true;

    public function register(Request $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 1;
        $user->save();

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);

    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => '- Error, password o email',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
        ]);

        if (JWTAuth::invalidate($request->token)) {
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully',
            ]);
            $request->token->delete();
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out',
            ], 500);
        }
    }

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

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired']);

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid']);

        } catch (JWTException $e) {

            return response()->json(['token_absent']);

        }

        return response()->json(compact('user'));
    }

}
