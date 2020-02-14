<?php

namespace App\Http\Controllers;

use App\Listas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{

    /**
     *  - Get Listas Admin
     * - Devuelve todas las listas ->Admin
     */
    public function getListasAdmin()
    {
        $listas = Listas::all()->toArray();
        return $listas;
    }

    /**
     *  - Get info lista admin
     * - Informacion de la lista especificada
     */
    public function infoListaAdmin($url)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        // - Id de la lista para agregar participantes
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        $lista = Listas::find($idLista);

        return $lista;
    }

    /**
     *  - Edit lista admin
     * - Edita cualquier lista
     */
    public function editListaAdmin($url, Request $request)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        // - Id de la lista para agregar participantes
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        $lista = Listas::find($idLista);

        $lista->url = $request->url;
        $lista->titulo = $request->titulo;
        $lista->descripcion = $request->descripcion;
        $lista->passwordLista = Hash::make($request->passwordLista);
        $lista->elementos = json_encode($request->elementos);
        
        if ($lista->update()) {
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
     *  - Del lista admin
     * - Elimina cualquier lista
     */
    public function delListAdmin($url)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        // - Id de la lista para agregar participantes
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        $lista = Listas::find($idLista);

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
