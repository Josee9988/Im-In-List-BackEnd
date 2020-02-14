<?php

use Illuminate\Support\Facades\Route;

/**
 *  - Por defecto CORS estara activo para toodas las rutas
 *  - Creado grupo de rutas que debe estan autenticadas
 */
Route::post('login', 'APIController@login');
Route::post('register', 'APIController@register');

/**
 *  - No registrados
 */
Route::get('list/{url}', 'noRegistradosListsController@getListUrl');
Route::post('list', 'noRegistradosListsController@addLista');
Route::put('list/{url}', 'noRegistradosListsController@editLista');
Route::delete('list/{url}', 'noRegistradosListsController@delList');

Route::group(['middleware' => 'auth.jwt'], function () {

    // - Datos del usuario logeado
    Route::get('user', 'APIController@getAuthenticatedUser');

    // - Gesion de administracion de los participantes
    Route::get('participate', 'api\participaUsuariosController@getListasParticipa');
    Route::post('participate', 'api\participaUsuariosController@addUserToList');
    Route::delete('participate', 'api\participaUsuariosController@delParticipantes');
    Route::post('participateUsers', 'api\participaUsuariosController@getParticipantes'); // DIF

    Route::get('listas', 'api\listasController@getLista');
    Route::get('listas/{url}', 'api\listasController@infoLista');
    Route::post('listas', 'api\listasController@addLista');
    Route::put('listas/{url}', 'api\listasController@editLista');
    Route::delete('listas/{url}', 'api\listasController@delList');

    // - Admin -> controlar
    Route::group(['middleware' => 'admin'], function () {

        Route::get('listasAdmin', 'adminController@getListasAdmin');
        //Route::post('listasAdmin', 'adminController@addLista');
        Route::get('listasAdmin/{url}', 'adminController@infoListaAdmin');
        Route::put('listasAdmin/{url}', 'adminController@editListaAdmin');
        Route::delete('listasAdmin/{url}', 'adminController@delListAdmin');
        
        Route::get('users', 'api\usuariosController@getUsers');
        Route::get('users/{id}', 'api\usuariosController@infoUser');
        Route::post('users', 'api\usuariosController@addUser');
        Route::put('users/{id}', 'api\usuariosController@editUser');
        Route::delete('users/{id}', 'api\usuariosController@delUser');

    });
});
