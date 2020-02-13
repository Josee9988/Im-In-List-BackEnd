<?php

use Illuminate\Support\Facades\Route;

/**
 *  - Por defecto CORS estara activo para toodas las rutas
 *  - Creado grupo de rutas que debe estan autenticadas
 */
Route::post('login', 'APIController@login');
Route::post('register', 'APIController@register');

Route::group(['middleware' => 'auth.jwt'], function () {

    // - Datos del usuario logeado
    Route::get('user', 'APIController@getAuthenticatedUser');

    // - Gesion de administracion de los participantes
    Route::get('participate', 'api\participaUsuariosController@getListasParticipa');
    Route::post('participate', 'api\participaUsuariosController@addUserToList');
    Route::delete('participate', 'api\participaUsuariosController@delParticipantes');
    Route::post('participateUsers', 'api\participaUsuariosController@getParticipantes'); // DIF

    Route::get('listas', 'api\listasController@getLista')->name('getListas');
    Route::get('listas/{id}', 'api\listasController@infoLista')->name('getLista');
    Route::post('listas', 'api\listasController@addLista')->name('addLista');
    Route::put('listas/{id}', 'api\listasController@editLista')->name('editLista');
    Route::delete('listas/{id}', 'api\listasController@delList')->name('delLista');

    // - Admin -> controlar
    Route::group(['middleware' => 'admin'], function () {

        Route::get('listas', 'api\listasController@getLista')->name('getListas');
        Route::get('listas/{id}', 'api\listasController@infoLista')->name('getLista');
        Route::post('listas', 'api\listasController@addLista')->name('addLista');
        Route::put('listas/{id}', 'api\listasController@editLista')->name('editLista');
        Route::delete('listas/{id}', 'api\listasController@delList')->name('delLista');

        Route::get('listasAdmin', 'api\listasController@getListasAdmin');
        Route::get('users', 'api\usuariosController@getUsers')->name('getUsers');
        Route::get('users/{id}', 'api\usuariosController@infoUser')->name('getUser');
        Route::post('users', 'api\usuariosController@addUser')->name('addUser');
        Route::put('users/{id}', 'api\usuariosController@editUser')->name('editUser');
        Route::delete('users/{id}', 'api\usuariosController@delUser')->name('delUser');

    });
});
