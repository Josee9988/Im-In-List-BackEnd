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
        return Listas::all();
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
        return $lista->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Listas::find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lista = Listas::find($id);
        $lista->idUsuarioCreador = $request->idUsuarioCreador;
        $lista->titulo = $request->titulo;
        $lista->descripcion = $request->descripcion;
        $lista->passwordLista = $request->passwordLista;
        $lista->elementos = $request->elementos;
        return $lista->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Listas::where('id', $id)->delete();
    }
}
