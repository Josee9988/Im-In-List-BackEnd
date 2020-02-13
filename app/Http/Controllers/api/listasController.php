<?php

namespace App\Http\Controllers\api;

use App\ParticipaUser;
use App\Listas;
use Illuminate\Http\Request;

/**
 *  - Extiende de controlador padre 
 */
class listasController extends protectedUserController
{

    /**
     *  - GETLISTAS
     * - Devuelve las listas que ha creado el usuario -> user
     */
    public function getLista()
    {

        $listaParticipantes = ParticipaUser::select('idLista')->get()->toArray();

        $listas = [];
        foreach ($listaParticipantes as $lista => $id) {

            
            $aux = Listas::where('id', $id)->get();

            array_push($listas, $aux);
        } // LISTAS
        
        // USUARIOS
        $userParticipantes = ParticipaUser::select('idUser')->get()->toArray();
        
        //$listas = $this->user->listas()->get()->toArray();
        

        
    }

    /**
     *  - GETLISTASADMIN
     * - Devuelve todas las listas ->Admin
     */
    public function getListasAdmin()
    {
        $listas = Listas::all()->toArray();
        return $listas;
    }

    /**
     *  - INFOLISTA
     * - Informacion de una lista si la ha creado el usuario -> user
     */
    public function infoLista($id)
    {
        $lista = Listas::find($id);

        if (!$id || !$lista || !$this->user->listas()->find($id)) {
            return response()->json([
                'message' => 'Error lista con el ' . $id . ' no se ha encontrado',
            ], 400);
        }

        return $lista;
    }

    /**
     *  - ADDLISTA
     * - Agrega una lista ->user 
     */
    public function addLista(Request $request)
    {
        $lista = new Listas();
        $lista->titulo = $request->titulo;
        $lista->descripcion = $request->descripcion;
        $lista->passwordLista = $request->passwordLista;
        $lista->elementos = $request->elementos;

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
    }

    /**
     *  - EDITLISTA
     * - Edita una lista por id -> user
     */
    public function editLista($id, Request $request)
    {
        $lista = $this->user->listas()->find($id);
        // - En caso de id erronea
        if (!$id || !$lista) {
            return response()->json([
                'message' => 'Error la lista con el ' . $id . ' no se ha modificado o encontrado',
            ], 400);
        }

        $updated = $lista->fill($request->all())->save();
        if ($updated) {
            return response()->json([
                'message' => 'Lista modificada correctamente',
                'lista' => $lista,
            ]);
        } else {
            return response()->json([
                'message' => 'Error la lista no se ha creado',
            ], 500);
        }
    }

    /**
     *  - DElLIST
     * - Elimina una lista por el id si la tiene el user -> user
     */
    public function delList($id)
    {
        $lista = $this->user->listas()->find($id);
        
        if (!$lista || !$id) {
            return response()->json([
                'message' => 'Error la lista no se ha encontrado',
            ], 400);
        }

        if ($lista->delete()) {
            return response()->json([
                'message' => 'Lista eliminada correctamente',
            ]);
        } else {
            return response()->json([
                'message' => 'Error la lista no se ha eliminado',
            ], 500);
        }
    }
}
