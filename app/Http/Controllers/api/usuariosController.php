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
     * getUsers
     * Summary: Devuelve todos los usuarios registrados
     *
     * @return void
     */
    public function getUsers()
    {
        $users = User::all();
        return $users;
    }

    /**
     * infoUser
     * Summary: Informacion de un usuario especifico
     *
     * @param  mixed $id -Id del usuario a buscar
     *
     * @return void
     */
    public function infoUser($id)
    {
        $usuario = User::find($id);

        if (!$id || !$usuario) {
            return response()->json([
                'message' => 'Error usuario con el ' . $id . ' no se ha encontrado'], 400);
        }
        return $usuario;
    }

    /**
     *  - FUERA DE SERVICIO
     *
     *  - Add user
     * - Agrega un usuario -> admin
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
                'user' => $usuario]);
        } else {
            return response()->json([
                'message' => 'Error el usuariono se ha creado'], 500);
        }
    }

    /**
     * editUser
     * Summary: Se busca el usuario, si somos admin, editara lo que quiera.
     *  Si somos un usuario, solo editara sus datos
     *
     * @param  mixed $id        - Id del usuario a buscar
     * @param  mixed $request   - Datos que recibe
     *
     * @return void
     */
    public function editUser($id, Request $request)
    {
        $usuario = User::find($id);
        if (!$id || !$usuario) {
            return response()->json([
                'message' => 'Error la usuario con el ' . $id . ' no se ha encontrado'], 400);
        }
        // - Admin
        if ($this->user->role == 0) {
            $usuario->name = $request->name;
            $usuario->email = $request->email;

            if (password_verify($request->oldPassword, $usuario->password)) {
                $usuario->password = Hash::make($request->password);

            } else if (empty($request->oldPassword)) {
                $usuario->password = $usuario->password;

            } else {
                return response()->json([
                    'message' => 'Error, password antigua incorrecta Admin'], 401);
            }

            $usuario->role = $request->role;

            // - USUARIO
        } else if ($this->user->id == $id) {
            $usuario->name = $request->name;
            $usuario->email = $request->email;

            if (password_verify($request->oldPassword, $usuario->password)) {
                $usuario->password = Hash::make($request->password);

            } else if (empty($request->oldPassword)) {
                $usuario->password = $usuario->password;
            } else {
                return response()->json([
                    'message' => 'Error, password antigua incorrecta'], 401);
            }
            $usuario->role = $usuario->role;

        } else {
            return response()->json(['message' => '¿Te crees admin?']);
        }

        $updated = $usuario->save();
        if ($updated) {
            return response()->json([
                'message' => 'Usuario modificado correctamente',
                'user' => $usuario]);
        } else {
            return response()->json(['message' => 'Error el usuario no se ha modificado'], 500);
        }
    }

    /**
     * delUser
     * Summary: Elimina cualquier usuario
     *
     * @param  mixed $id - Usuario a eliminar
     *
     * @return void
     */
    public function delUser($id)
    {
        $usuario = $this->infoUser($id);
        if (!$usuario || !$id) {
            return response()->json([
                'message' => 'Error la usuario no se ha encontrado'], 400);
        }

        if ($usuario->delete()) {
            return response()->json(['message' => 'usuario eliminada correctamente']);
        } else {
            return response()->json([
                'message' => 'Error el usuario no se ha eliminado'], 500);
        }

    }
}
