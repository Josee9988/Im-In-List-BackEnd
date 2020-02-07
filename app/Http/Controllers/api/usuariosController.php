<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class usuariosController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::all();
        return $users;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->role = $request->role;
        $usuario->listasCreadas = $request->listasCreadas;
        $usuario->listasParticipantes = $request->listasParticipantes;

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
