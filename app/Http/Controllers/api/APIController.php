<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class APIController extends Controller
{
    /**
     * register
     * Summary: Crea un usuario y le genera un token
     *
     * @param  mixed $request -Datos que recibe para crear un usuario
     *
     * @return void
     */
    public function register(Request $request)
    {
        $peticionUrl = file_get_contents($this->url . '?secret=' . $this->private_key . '&response=' . $request->captcha);
        $estadoCaptcha = json_decode($peticionUrl)->success;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:60',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

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
            return response()->json(['message' => 'Error, Actividad sospechosa']);
        }
        return response()->json(['message' => 'Error, No se ha registrado el usuario']);
    }

    /**
     * login
     * Summary: Si email y password son correctos se genera el token
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'message' => '- Error de login, password o email incorrectos'], 401);
        }

        return response()->json(['token' => $token]);
    }

    /**
     * refreshToken
     * Summary: Refresca el token, (genera uno nuevo)
     *
     * @return void
     */
    public function refreshToken()
    {
        $token = JWTAuth::getToken();
        try {
            $token = JWTAuth::refresh($token);
            return response()->json(['token' => $token], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Vuelve al login'], 422);
        }
    }

    /**
     * getAuthenticatedUser
     * Summary: Devuelve el usuario logeado
     *
     * @return void
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

}
