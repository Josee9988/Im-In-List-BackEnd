<?php

namespace App\Http\Controllers\api;

use App\Listas;
use App\ParticipaUser;
use App\User;
use Illuminate\Http\Request;

class participaUsuariosController extends listasController
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
     *  - GETPARTICIPANTES
     * - Devuelve los participantes de una lista
     */
    public function getParticipantes(Request $request)
    {
        $lista = Listas::where('url', $request->url)->select('id')->get();

        // - Id de la lista para ver los participantes
        $auxLista = json_decode($lista);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        if ($this->user->id == $this->user_id($request)) {

            $users = ParticipaUser::where('idLista', $idLista)->select('idUser')->get()->toArray();

            $usuarios = [];
            foreach ($users as $user => $id) {

                $aux = User::where('id', $id)->get();
                array_push($usuarios, $aux);
            }
            return $usuarios;
        }

        return response()->json([
            'message' => 'Error ¿Creador de la lista?',
        ]);
    }

    /**
     *  - ADDUSERTOLIST
     * - Agrega un usuario a la lista
     */
    public function addUserToList(Request $request)
    {

        $user = User::where('email', $request->email)->select('id')->get();
        $lista = Listas::where('url', $request->url)->select('id')->get();
        $user_id = Listas::where('url', $request->url)->select('user_id')->get();

        // - Id de la lista para agregar participantes
        $auxUserParticipar = json_decode($user);
        if (empty($auxUserParticipar[0]->id)) {
            return response()->json([
                'message' => 'Error ¿email agregado?',
            ]);
        }
        $idUserParticipar = $auxUserParticipar[0]->id;

        // - Id de la lista para agregar participantes
        $auxLista = json_decode($lista);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        // - Si el usuario es el creador de la lista podra agregar
        $auxUser = json_decode($user_id);
        $idUsuarioCreador = $auxUser[0]->user_id;

        if ($this->user->id == $idUsuarioCreador) {

            // Nuevo participante
            $listaParticipa = new ParticipaUser();
            $listaParticipa->idUser = $idUserParticipar;
            $listaParticipa->idLista = $idLista;
            $listaParticipa->save();

            $participantes = Listas::find($idLista);
            $participantes->participantes += 1;
            $participantes->save();

            $listaFinal = Listas::where('id', $idLista)->get()->toArray();
            return response()->json([
                'message' => 'Usuario agregado',
                'lista' => $listaFinal,
            ]);
        }
        return response()->json([
            'message' => 'Error usuario no agregado, ¿ Eres el creador de la lista ?',
        ]);
    }

    public function delParticipantes(Request $request)
    {

        $user = User::where('email', $request->email)->select('id')->get();
        $lista = Listas::where('url', $request->url)->select('id')->get();

        // - Id de la lista para agregar participantes
        $auxUserParticipar = json_decode($user);
        if (empty($auxUserParticipar[0]->id)) {
            return response()->json([
                'message' => 'Error ¿email agregado?',
            ]);
        }
        $usuario = $auxUserParticipar[0]->id;

        // - Id de la lista para agregar participantes
        $auxLista = json_decode($lista);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;

        $delParticipante = ParticipaUser::where('idUser', $usuario)->where('idLista', $idLista)->select('id');
        
        if ($delParticipante->delete()) {
            return response()->json([
                'message' => 'Usuario eliminado de la lista',
            ]);
        } else {
            return response()->json([
                'message' => 'Error usuario no eliminado de la lista',
            ], 500);
        }

    }

    public function user_id($request)
    {
        $user_id = Listas::where('url', $request->url)->select('user_id')->get();

        // - Si el usuario es el creador de la lista podra agregar
        $auxUser = json_decode($user_id);
        $idUsuarioCreador = $auxUser[0]->user_id;

        return $idUsuarioCreador;
    }
}
