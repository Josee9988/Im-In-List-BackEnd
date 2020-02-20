<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Listas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{

    /**
     * getListasAdmin
     * Summary: Devuelve todas las listas ->Admin
     *
     * @return void
     */
    public function getListasAdmin()
    {
        $listas = Listas::all()->toArray();
        return $listas;
    }

    /**
     * infoListaAdmin
     * Summary: Informacion de la lista especificada
     *
     * @param  mixed $url - Mediante la url se cogera el id de la lista a mostrar
     *
     * @return void
     */
    public function infoListaAdmin($url)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json(['message' => 'Error ¿existe la lista?']);
        }
        $idLista = $auxLista[0]->id;
        $lista = Listas::find($idLista);
        return $lista;
    }

    /**
     * editListaAdmin
     * Summary: Edita cualquier lista
     *
     * @param  mixed $url      - Url(id) para editar la lista
     * @param  mixed $request  - Datos que recibe para modificar la lista
     *
     * @return void
     */
    public function editListaAdmin($url, Request $request)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json(['message' => 'Error ¿existe la lista?']);
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
                'lista' => $lista]);
        } else {
            return response()->json([
                'message' => 'Error la lista no se ha creado'], 500);
        }
    }

    /**
     * delListAdmin
     * Summary: Elimina cualquier lista
     *
     * @param  mixed $url(id) -Url de la lista a eliminar
     *
     * @return void
     */
    public function delListAdmin($url)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json(['message' => 'Error ¿existe la lista?']);
        }
        $idLista = $auxLista[0]->id;

        $lista = Listas::find($idLista);
        if ($lista->delete()) {
            return response()->json([
                'message' => 'Lista eliminada correctamente']);
        }
        return response()->json(['message' => 'Error la lista no se ha eliminado'], 500);
    }

}
