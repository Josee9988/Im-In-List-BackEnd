<?php

use Illuminate\Support\Facades\Route;

// - C O R S -> activado para todas las rutas

Route::post('sendEmail','emailController@gestionEmail');

Route::post('login', 'APIController@login');
Route::post('register', 'APIController@register');

// - No registrados
Route::get('list/{url}', 'noRegistradosListsController@getList');
Route::post('list', 'noRegistradosListsController@addLista');
Route::put('list/{url}', 'noRegistradosListsController@editLista');
Route::delete('list/{url}', 'noRegistradosListsController@delList');

// - Autenticados requiere -> token
Route::group(['middleware' => 'auth.jwt'], function () {

    Route::get('refresh', 'APIController@refreshToken');

    // - Datos del usuario logeado
    Route::get('user', 'APIController@getAuthenticatedUser');

    // - Para poder editar el usuario
    Route::put('users/{id}', 'api\usuariosController@editUser');

    // - Gestion de listas para los usuarios
    Route::get('listas', 'api\listasController@getLista');
    Route::get('listas/{url}', 'api\listasController@infoLista');
    Route::post('listas', 'api\listasController@addLista');
    Route::put('listas/{url}', 'api\listasController@editLista');
    Route::delete('listas/{url}', 'api\listasController@delList');

    // - Admin
    Route::group(['middleware' => 'admin'], function () {

        // - Rutas de admin frente a todas las listas
        Route::get('listasAdmin', 'adminController@getListasAdmin');
        //Route::post('listasAdmin', 'adminController@addLista');
        Route::get('listasAdmin/{url}', 'adminController@infoListaAdmin');
        Route::put('listasAdmin/{url}', 'adminController@editListaAdmin');
        Route::delete('listasAdmin/{url}', 'adminController@delListAdmin');

        // - Gestion de usuarios
        Route::get('users', 'api\usuariosController@getUsers');
        Route::get('users/{id}', 'api\usuariosController@infoUser');
        Route::delete('users/{id}', 'api\usuariosController@delUser');
        //Route::post('users', 'api\usuariosController@addUser');

    });
});
