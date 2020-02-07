<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Listas;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class listasController extends Controller
{
    /**
     * @var
     */
    protected $user;

    /**
     * ListasController constructor.
     */
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listas = $this->user->listas()->get(['titulo', 'descripcion', 'passwordLista', 'elementos'])->toArray();
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lista = Listas::find($id);

        // - En caso de id erronea
        if (!$id || !$lista) {
            return response()->json([
                'message' => 'Error lista con el ' . $id . ' no se ha encontrado',
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lista = $this->user->listas()->find($id);

        // - En caso de id erronea
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
