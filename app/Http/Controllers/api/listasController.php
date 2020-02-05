<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Listas;
use Illuminate\Http\Request;

class listasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listas = $this->user->listas()->get(['titulo'])->toArray();

        return $listas;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lista = new Listas();
        $lista->idUsuarioCreador = $request->idUsuarioCreador;
        $lista->titulo = $request->titulo;
        $lista->descripcion = $request->descripcion;
        $lista->passwordLista = $request->passwordLista;
        $lista->elementos = $request->elementos;
        $lista->save();
        return $lista;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $lista = Listas::find($id);
        if (!$lista) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, task with id ' . $id . ' cannot be found.'
            ], 400);
        }
        return $lista;
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
        $lista = Listas::find($id);
        $lista->fill($request->all())->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lista = Listas::where('id', $id)->delete();

        return $lista;
    }
}
