<?php

namespace App\Http\Controllers\api;

use App\Listas;
use App\ParticipaUser;
use Illuminate\Http\Request;
use App\User;

class participaUsuariosController extends protectedUserController
{

    /**
     *  - GETLISTASPARTICIPA
     * - Devuelve las listas en que participa
     */
    public function getListasParticipa()
    {
        $listaParticipantes = ParticipaUser::where('idUser', $this->user->id)->select('idLista')->get()->toArray();

        $listas = [];
        foreach ($listaParticipantes as $lista => $id) {

            $aux = Listas::where('id', $id)->get();

            array_push($listas, $aux);
        }

        return $listas;
    }

    /**
     *  - ADDUSERTOLIST
     * - Agrega un usuario a la lista
     */
    public function addUserToList(Request $request)
    {
        $listaParticipa = new ParticipaUser();
        
        $user = User::where('email', $request->email)->select('id')->get()->toArray();
        $lista = Listas::where('email', $request->email)->select('id')->get()->toArray();

        return $user;

        $listaParticipa->idUser = $request->user;
        $listaParticipa->idLista= $request->descripcion;
/*
        if ($this->user->listas()->save($lista)) {
            return response()->json([
                'message' => 'Lista creada correctamente',
                'lista' => $lista,
            ]);
        } else {
            return response()->json([
                'message' => 'Error la lista no se ha creado',
            ], 500);
        }
        */
    }
}
