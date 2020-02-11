<?php

namespace App\Http\Controllers\api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 *  - Extiende de controlador padre
 */
class usuariosController extends protectedUserController
{

    /**
     *  - GETUSERS
     * - Devuelve los usuarios -> admin
     */
    public function getUsers()
    {

        $users = User::all();
        return $users;
    }

    /**
     *  - INFOUSER
     * - Informacion de un usuario
     */
    public function infoUser($id)
    {

        $usuario = User::find($id);

        // - En caso de id erronea
        if (!$id || !$usuario) {
            return response()->json([
                'message' => 'Error usuario con el ' . $id . ' no se ha encontrado',
            ], 400);
        }

        return $usuario;

    }

    /**
     *  - ADDUSER
     * - Agrega un usuario ->user
     */
    public function addUser(Request $request)
    {
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->role = 1;
        $usuario->listasCreadas = $request->listasCreadas;
        $usuario->listasParticipantes = $request->listasParticipantes;

        $token = JWTAuth::fromUser($usuario);

        if ($usuario->save()) {
            return response()->json([
                'message' => 'Usuario creado correctamente',
                'token' => $token,
                'user' => $usuario,
            ]);
        } else {
            return response()->json([
                'message' => 'Error el usuariono se ha creado',
            ], 500);
        }

    }

    /**
     *  - EDITUSER
     * - Edita una lista por id -> user
     */
    public function editUser($id, Request $request)
    {
        $usuario = User::find($id);

        // - En caso de id erronea
        if (!$id || !$usuario) {
            return response()->json([
                'message' => 'Error la usuario con el ' . $id . ' no se ha modificado o encontrado',
            ], 400);
        }

        $updated = $usuario->fill($request->all())->save();

        if ($updated) {
            return response()->json([
                'message' => 'usuario modificado correctamente',
                'user' => $usuario,
            ]);
        } else {
            return response()->json([
                'message' => 'Error el usuario no se ha creado',
            ], 500);
        }
    }

    /**
     *  - DELUSER
     * - Elimina un usuario
     */
    public function delUser($id)
    {
        $usuario = $this->show($id);

        // - En caso de id erronea
        if (!$usuario || !$id) {
            return response()->json([
                'message' => 'Error la usuario no se ha encontrado',
            ], 400);
        }

        if ($usuario->delete()) {
            return response()->json([
                'message' => 'usuario eliminada correctamente',
            ]);
        } else {
            return response()->json([
                'message' => 'Error el usuario no se ha eliminado',
            ], 500);
        }

    }
}
