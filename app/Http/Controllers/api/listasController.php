<?php

namespace App\Http\Controllers\api;

use App\Listas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        //array_push($listas, $this->user->listas()->get());
        $listas = $this->user->listas()->get()->toArray();

        return $listas;

    }

    /**
     *  - INFOLISTA
     * - Informacion de una lista si la ha creado el usuario -> user
     */
    public function infoLista($url)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        $lista = $this->user->listas()->find($idLista);
        return $lista;
    }

    /**
     *  - ADDLISTA
     * - Agrega una lista ->user
     */
    public function addLista(Request $request)
    {

        // - usuario/personalida /P
        // - usuario/aleatorio   /R
        // - /aleatorio         /0
        $lista = new Listas();

        if ($this->user->role == 0 || $this->user->role == 2) {
            $lista->url = $this->user->name . '_' . $request->url;

        } else if ($this->user->role == 1) {

            $lista->url = $this->user->name . '_' . $this->random();

        } else {
            $lista->url = '_' . $this->random();
        }

        $lista->titulo = $request->titulo;
        $lista->descripcion = $request->descripcion;

        if ($this->user->role == 0 || $this->user->role == 2) {
            $lista->passwordLista = Hash::make($request->passwordLista);
        } else {
            $lista->passwordLista = null;
        }

        $lista->elementos = json_encode($request->elementos);

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

    public function random()
    {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     *  - EDITLISTA
     * - Edita una lista por id -> user
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

        $lista = Listas::find($idLista);

        if ($this->user->listas()->find($idLista)) {
            if ($this->user->role == 0 || $this->user->role == 2) {
                $lista->url = $this->user->name . '_' . $request->url;

            } else if ($this->user->role == 1) {
                $lista->url = $this->user->name . '_' . $this->random();

            } else {
                $lista->url = '_' . $this->random();
            }
        }

        $lista->titulo = $request->titulo;
        $lista->descripcion = $request->descripcion;
        
        if ($this->user->listas()->find($idLista)) {
            if ($this->user->role == 0 || $this->user->role == 2) {
                $lista->passwordLista = Hash::make($request->passwordLista);
            } else {
                $lista->passwordLista = null;
            }
        }
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

        $lista = $this->user->listas()->find($idLista);

        if ($lista) {
            $lista->delete();
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
