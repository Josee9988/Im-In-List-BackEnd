<?php

namespace App\Http\Controllers;

use App\Listas;
use Illuminate\Http\Request;

class noRegistradosListsController extends Controller
{
    /**
     *  - Get lista 
     * - Ve una lista por una url
     */
    public function getList($url)
    {

        $urlRecibida = Listas::where('url', $url)->get();

        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        // - Lista
        $listas = Listas::find($idLista);

        return $listas;

    }

    /**
     *  - Agregar lista
     * - Agrega una lista aunque no estes registrado
     */
    public function addLista(Request $request)
    {

        // - usuario_personalida -> 2 Premium
        // - usuario_aleatorio   -> 1 Registrado
        // - _aleatorio          -> inexistente No registrado

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
     *  - Editar 
     * - Edita una lista por la ur -> usuario no reguistrado
     */
    public function editLista($url, Request $request)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        // - Tenemos la lista
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
     *  - Eliminar lista
     * - Elimina la lista por url
     */
    public function delList($url)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();

        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        // - Tenemos la lista
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
