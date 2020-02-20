<?php

namespace App\Http\Controllers\api;

use App\Listas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 *  - Extiende de controlador padre
 */
class listasController extends protectedUserNullController
{
    /**
     * getLista
     * Summary: Devuelve las listas que ha creado el usuario
     *
     * @return void
     */
    public function getLista()
    {
        if ($this->user) {
            $listas = $this->user->listas()->get()->toArray();
        } else {
            return response()->json(['message' => 'Este usuario no esta registrado']);
        }
        return $listas;
    }

    /**
     * infoListaPassword
     * Summary: Delvuelve un lista por la url, se ha de pasar la password
     *
     * @param  mixed $url       -Url(id) a buscar
     * @param  mixed $listaAuth -Password que se pasa para acceder
     *
     * @return void
     */
    public function infoListaPassword($url, $listaAuth)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        $auxLista = json_decode($urlRecibida);

        if (empty($auxLista[0]->id)) {
            return response()->json(['message' => 'Error ¿existe la lista?']);
        }

        $idLista = $auxLista[0]->id;
        $lista = Listas::find($idLista);

        if ($lista->passwordLista != null) {
            if (empty($listaAuth)) {
                return response()->json(['message' => 'Error, indique la contraseña de la lista']);
            }
            if (password_verify($listaAuth, $lista->passwordLista)) {
                return $lista;
            } else {
                return response()->json(['message' => 'Error, indique la contraseña de la lista']);
            }
        }
        return $lista;
    }

    /**
     * infoLista
     * Summary: Delvuelve un lista por la url
     *  En caso de tener password la lista se ejecutara otra funcion
     *
     * @param  mixed $url -Url(id) a buscar
     *
     * @return void
     */
    public function infoLista($url)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        $auxLista = json_decode($urlRecibida);

        if (empty($auxLista[0]->id)) {
            return response()->json(['message' => 'Error ¿existe la lista?']);
        }

        $idLista = $auxLista[0]->id;
        $lista = Listas::find($idLista);

        if ($lista->passwordLista != null) {
            return response()->json(['message' => 'Error, indique la contraseña de la lista']);
        }
        return $lista;
    }

    /**
     * addLista
     * Summary: Agrega una lista
     * Depende del tipo de usuario: Rol(0,1,2)
     *  tendra unas opciones u otras
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function addLista(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|min:4|max:60',
            'descripcion' => 'required|string|min:4|max:60',
            'passwordLista ' => 'string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $lista = new Listas();

        // - Usuario registrado/premium/admin
        if ($this->user) {
            if ($this->user->role == 0 || $this->user->role == 2) {

                $listasURL = Listas::where('url', $lista->url )->select('url')->get()->toArray();
                if (!empty($listasURL)) {
                    return response()->json(['message' => 'Error url existente'], 400);
                }

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
                    'lista' => $lista]);
            } else {
                return response()->json(['message' => 'Error la lista no se ha creado'], 500);
            }

            // - Usuario no registrado
        } else {
            $lista->url = '_' . $this->random();
            $lista->titulo = $request->titulo;
            $lista->descripcion = $request->descripcion;
            $lista->passwordLista = null;
            $lista->elementos = json_encode($request->elementos);

            if ($lista->save()) {
                return response()->json([
                    'message' => 'Lista creada correctamente',
                    'lista' => $lista]);
            } else {
                return response()->json(['message' => 'Error la lista no se ha creado'], 500);
            }
        }
        return response()->json(['message' => 'Error grave'], 500);
    }

    /**
     * random
     * Summary: Crea un string random para la url
     *
     * @return void
     */
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
     * editLista
     * Summary: Edita una lista, si contiene contraseña se solictara
     * Depende del tipo de usuario: Rol(0,1,2) tendra unas opciones u otras
     * Podran editar _todos_ el titulo, asunto y elementos
     *
     * @param  mixed $url       - Url para buscar la lista
     * @param  mixed $request   - Datos que recibe
     *
     * @return void
     */
    public function editLista($url, Request $request)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json(['message' => 'Error ¿existe la lista?']);
        }
        $idLista = $auxLista[0]->id;
        $lista = Listas::find($idLista);

        // - Si tiene contraseña
        if ($lista->passwordLista != null) {
            if (password_verify($request->listaAuth, $lista->passwordLista)) {
                $lista = $this->editar($idLista, $request);
            } else {
                return response()->json(['message' => 'Error, indique la contraseña de la lista']);
            }

            // - Si NO tiene contraseña
        } else {
            $lista = $this->editar($idLista, $request);
        }

        if ($lista->update()) {
            return response()->json([
                'message' => 'Lista modificada correctamente',
                'lista' => $lista]);
        } else {
            return response()->json(['message' => 'Error la lista no se ha creado'], 500);
        }
    }

    /**
     * editar
     * Summary: Funcion de editar II
     * Aqui se edita el contenido de la lista dependiendo del ususario
     *
     * @param  mixed $idLista  - ID para buscar la lista
     * @param  mixed $request  - Datos recibidos
     *
     * @return void
     */
    public function editar($idLista, $request)
    {
        $lista = Listas::find($idLista);

        //USUARIO
        if ($this->user) {

            $lista->url = $lista->url;
            $lista->titulo = $request->titulo;
            $lista->descripcion = $request->descripcion;

            if (isset($request->passwordLista)) {
                // - PasswordLista
                // - Si eres el dueño de la lista podras poner password a la lista
                if ($this->user->listas()->find($idLista)) {
                    if ($this->user->role == 0 || $this->user->role == 2) {
                        $lista->passwordLista = Hash::make($request->passwordLista);

                    } else if ($lista->passwordLista != null) {
                        $lista->passwordLista = $lista->passwordLista;

                    } else {
                        $lista->passwordLista = null;
                    }
                }
            } else {
                $lista->passwordLista = null;
            }

            $lista->elementos = json_encode($request->elementos);

            return $lista;

            // NO REGISTRADO
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
     * delList
     * Summary: Elimina una lista si es el creador de ella
     * Las listas sin creador las elimina el admin
     *
     * @param  mixed $url -Url(id) para buscar la lista
     *
     * @return void
     */
    public function delList($url)
    {
        $urlRecibida = Listas::where('url', $url)->select('id')->get();
        $auxLista = json_decode($urlRecibida);
        if (empty($auxLista[0]->id)) {
            return response()->json(['message' => 'Error ¿existe la lista?']);
        }
        $idLista = $auxLista[0]->id;
        $lista = $this->user->listas()->find($idLista);

        if ($lista) {
            $lista->delete();
            return response()->json(['message' => 'Lista eliminada correctamente']);
        } else {
            return response()->json(['message' => 'Error la lista no se ha eliminado, eres el creador'], 500);
        }
    }
}
