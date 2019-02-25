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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/Clients', function(){
	return view('Clients.clientes');
});
Route::get('/Clients', function(){
	return view('Clients.detalle_ven');
});
Route::get('/Clients', function(){
	return view('Clients.detalle_cli');
});

