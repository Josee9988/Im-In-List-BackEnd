<?php

use Illuminate\Support\Facades\Route;

// - C O R S -> activado para todas las rutas

Route::post('sendEmail', 'api\emailController@gestionEmail');

Route::post('login', 'api\APIController@login');
Route::post('register', 'api\APIController@register');

// - Gestion de listas para los usuarios
Route::get('listas', 'api\listasController@getLista');
Route::get('listas/{url}', 'api\listasController@infoLista');
Route::get('listas/{url}/{listaAuth}', 'api\listasController@infoListaPassword');
Route::post('listas', 'api\listasController@addLista');
Route::put('listas/{url}', 'api\listasController@editLista');
Route::delete('listas/{url}', 'api\listasController@delList');

// - Autenticados requiere -> token
Route::group(['middleware' => 'auth.jwt'], function () {

    Route::get('refresh', 'api\APIController@refreshToken');

    // - Datos del usuario logeado
    Route::get('user', 'api\APIController@getAuthenticatedUser');

    // - Para poder editar el usuario
    Route::put('users/{id}', 'api\usuariosController@editUser');

    Route::get('pago', 'api\paymentController@execute');

    // - Admin
    Route::group(['middleware' => 'admin'], function () {

        // - Rutas de admin frente a todas las listas
        Route::get('listasAdmin', 'api\adminController@getListasAdmin');
        //Route::post('listasAdmin', 'api\adminController@addLista');
        Route::get('listasAdmin/{url}', 'api\adminController@infoListaAdmin');
        Route::put('listasAdmin/{url}', 'api\adminController@editListaAdmin');
        Route::delete('listasAdmin/{url}', 'api\adminController@delListAdmin');

        // - Gestion de usuarios
        Route::get('users', 'api\usuariosController@getUsers');
        Route::get('users/{id}', 'api\usuariosController@infoUser');
        Route::delete('users/{id}', 'api\usuariosController@delUser');
        //Route::post('users', 'api\usuariosController@addUser');

    });
});
