<?php

Route::post('login', 'APIController@login');
Route::post('register', 'APIController@register');

Route::group(['middleware' => 'auth.jwt'], function () {

    Route::get('logout', 'APIController@logout');

    Route::get('listas', 'api\listasController@index')->name('getListas');
    Route::get('listas/{id}', 'api\listasController@show')->name('getLista');
    Route::post('listas', 'api\listasController@store')->name('addLista');
    Route::put('listas/{id}', 'api\listasController@update')->name('editLista');
    Route::delete('listas/{id}', 'api\listasController@destroy')->name('delLista');

    Route::get('users', 'api\usuariosController@index')->name('getUsers');
    Route::get('users/{id}', 'api\usuariosController@show')->name('getUser');
    Route::post('users', 'api\usuariosController@store')->name('addUser');
    Route::put('users/{id}', 'api\usuariosController@update')->name('editUser');
    Route::delete('users/{id}', 'api\usuariosController@destroy')->name('delUser');
});
