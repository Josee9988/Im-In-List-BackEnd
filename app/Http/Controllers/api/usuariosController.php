<?php

namespace App\Http\Controllers\api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        if ($usuario->save()) {
            return response()->json([
                'message' => 'Usuario creado correctamente',
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

        if (!$id || !$usuario) {
            return response()->json([
                'message' => 'Error la usuario con el ' . $id . ' no se ha encontrado',
            ], 400);
        }

        if ($this->user->role == 0) {
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->role = $request->role;
        } else if($this->user->id == $id) {
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->role = $usuario->role;
        }else{
            return response()->json([
                'message' => '¿Te crees admin?',
            ]);
        }

        $updated = $usuario->save();

        if ($updated) {
            return response()->json([
                'message' => 'Usuario modificado correctamente',
                'user' => $usuario,
            ]);
        } else {
            return response()->json([
                'message' => 'Error el usuario no se ha modificado',
            ], 500);
        }
    }

    /**
     *  - DELUSER
     * - Elimina un usuario
     */
    public function delUser($id)
    {
        $usuario = $this->infoUser($id);

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
