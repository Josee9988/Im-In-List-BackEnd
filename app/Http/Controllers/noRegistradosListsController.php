<?php

namespace App\Http\Controllers;

use App\Listas;
use Illuminate\Http\Request;

class noRegistradosListsController extends Controller
{
    /**
     *  - GetListasByUrl
     * - Devuelve la lista por la url
     */
    public function getListUrl($url)
    {

        $urlRecibida = Listas::where('url', $url)->get();

        // - Id de la lista para agregar participantes
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        $listas = Listas::find($idLista);

        return $listas;

    }

    /**
     *  - AddListasNoRegistrado
     * - Agrega una lista
     */
    public function addLista(Request $request)
    {

        // - usuario/personalida /P
        // - usuario/aleatorio   /R
        // - /aleatorio         /0

        $lista = new Listas();

        $lista->url = '_' . $this->random();

        $lista->titulo = $request->titulo;
        $lista->descripcion = $request->descripcion;

        $lista->passwordLista = null;

        $lista->elementos = json_encode($request->elementos);

        if ($lista->save()) {
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
    public function random()
    {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     *  - EDITLISTA
     * - Edita una lista por id -> user
     */
    public function editListaAdmin($url, Request $request)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        $lista = Listas::find($idLista);

        $lista->titulo = $request->titulo;
        $lista->descripcion = $request->descripcion;
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
     *  - DElLIST
     * - Elimina una lista por el id si la tiene el user -> user
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
