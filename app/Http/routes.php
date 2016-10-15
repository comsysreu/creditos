<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('src');
});

Route::group(['prefix' => 'ws'], function() {
	Route::resource('tipousuarios', 		'TipoUsuariosController');
	Route::resource('sucursales', 			'SucursalesController');
	Route::resource('planes', 				'PlanesController');
	Route::resource('montosprestamo',		'MontosPrestamoController');
	Route::resource('clientes',				'ClientesController');
	Route::resource('referenciasclientes',	'ReferenciasPersonalesClientesController');
	Route::resource('creditos',				'CreditosController');
	Route::resource('usuarios',				'UsuariosController');
	Route::post('login',					'UsuariosController@login');
	Route::get('logout',function() {
		Auth::logout();
		return \Redirect::to('/');
	});
});

