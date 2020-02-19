<?php

namespace App\Http\Controllers\api;

use App\Listas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 *  - Extiende de controlador padre
 */
class listasController extends protectedUserNullController
{

    /**
     *  - GETLISTAS
     * - Devuelve las listas que ha creado el usuario -> user
     */
    public function getLista()
    {

        //array_push($listas, $this->user->listas()->get());
        if ($this->user) {
            $listas = $this->user->listas()->get()->toArray();
        } else {
            return response()->json([
                'message' => 'Este usuario no esta registrado',
            ]);
        }

        return $listas;

    }

    /**
     *  - INFOLISTA
     * - Informacion de una lista si la ha creado el usuario -> user
     */
    public function infoListaPassword($url, $listaAuth)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json([
                'message' => 'Error ¿existe la lista?',
            ]);
        }
        $idLista = $auxLista[0]->id;
        // - Lista
        $lista = Listas::find($idLista);

        if ($lista->passwordLista != null) {
            if (empty($listaAuth)) {
                return response()->json([
                    'message' => 'Error, indique la contraseña de la lista',
                ]);
            }

            if (password_verify($listaAuth, $lista->passwordLista)) {
                return $lista;
            } else {
                return response()->json([
                    'message' => 'Error, indique la contraseña de la lista',
                ]);
            }
        }
        return $lista;

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
        // - Lista
        $lista = Listas::find($idLista);

        if ($lista->passwordLista != null) {

            return response()->json([
                'message' => 'Error, indique la contraseña de la lista',
            ]);

        }
        return $lista;

    }

    /**
     *  - ADDLISTA
     * - Agrega una lista ->user
     */
    public function addLista(Request $request)
    {
        // - usuario_personalida -> 2 Premium
        // - usuario_aleatorio   -> 1 Registrado
        // - _aleatorio          -> inexistente No registrado

        $lista = new Listas();

        if ($this->user) {

            if ($this->user->role == 0 || $this->user->role == 2) {
                $lista->url = $this->user->name . '_' . $request->url;

            } else if ($this->user->role == 1) {

                $lista->url = $this->user->name . '_' . $this->random();

            } else {
                $lista->url = '_' . $this->random();
            }

            $lista->titulo = $request->titulo;
            $lista->descripcion = $request->descripcion;

            if (!empty($request->passwordLista)) {
                if ($this->user->role == 0 || $this->user->role == 2) {
                    $lista->passwordLista = Hash::make($request->passwordLista);
                }
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

        } else {

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

        return response()->json([
            'message' => 'Error grave',
        ], 500);

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

        if ($lista->passwordLista != null) {
            if (password_verify($request->listaAuth, $lista->passwordLista)) {
                $lista = $this->editar($idLista, $request);
            } else {
                return response()->json([
                    'message' => 'Error, indique la contraseña de la lista',
                ]);
            }
        } else {
            $lista = $this->editar($idLista, $request);
        }

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

    public function editar($idLista, $request)
    {
        $lista = Listas::find($idLista);

        if ($this->user) {


            /***
             * ***
             * AQUIIIIIIIIIIIIIIIIIIII
             */
            // - URL
            // - Si eres el dueño de la lista podras editar la url de tu lista
            if ($this->user->listas()->find($idLista)) {
                // - Dependiendo de tu rol podras o no
                if ($this->user->role == 0 || $this->user->role == 2) {
                    

                } else if ($this->user->role == 1) {
                    $lista->url = $lista->url;

                } else {
                    $lista->url = $lista->url;
                }
            }
            $lista->url = $lista->url;
            $lista->titulo = $request->titulo;
            $lista->descripcion = $request->descripcion;

            // - PasswordLista
            // - Si eres el dueño de la lista podras poner password a la lista
            if ($this->user->listas()->find($idLista)) {
                // - Depende de tu rol podras o no
                if ($this->user->role == 0 || $this->user->role == 2) {
                    $lista->passwordLista = Hash::make($request->passwordLista);
                } else if ($lista->passwordLista != null) {
                    $lista->passwordLista = $lista->passwordLista;
                } else {
                    $lista->passwordLista = null;
                }
            }

            $lista->elementos = json_encode($request->elementos);

            return $lista;

        } else {

            $lista->url = $lista->url;
            $lista->titulo = $request->titulo;
            $lista->descripcion = $request->descripcion;
            $lista->passwordLista = $lista->passwordLista;
            $lista->elementos = json_encode($request->elementos);

            return $lista;
        }
    }

    /**
     *  - Del Lista
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
                'message' => 'Error la lista no se ha eliminado, eres el creador',
            ], 500);
        }
    }
}
