<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('home');
});*/

Route::get('/', 'ClientsController@index');

Route::post('/clients/create','ClientsController@create');

Route::get('/clients/{id}', 'ClientsController@show');

Route::post('/clients/{id}', 'ClientsController@edit');

/*Route::get('/Clients', function(){
	return view('Clients.detalle_cli');
});*/

