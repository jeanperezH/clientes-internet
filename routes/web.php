<?php

use Illuminate\Support\Facades\Route;

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
    //return view('welcome');
    return view('contenido.contenido');
});
//Sedes
Route::get('/sede','SedeController@index');
Route::post('/sede/registrar','SedeController@store');
Route::put('/sede/actualizar','SedeController@update');
Route::get('/sede/selectSede','SedeController@selectSede');
//Rol
Route::get('/rol','RolController@index');
Route::post('/rol/registrar','RolController@store');
Route::put('/rol/actualizar','RolController@update');
Route::put('/rol/actualizar','RolController@update');
Route::put('/rol/activar', 'RolController@activar');
Route::put('/rol/desactivar', 'RolController@desactivar');
Route::get('/rol/selectrol','RolController@selectRol');
//Clientes
Route::get('/clientes','ClienteController@index');
Route::post('/clientes/registrar','ClienteController@store');
Route::put('/clientes/actualizar','ClienteController@update');
Route::get('/clientes/selectCliente','ClienteController@selectCliente');
//Personas
Route::get('/personas','PersonaController@index');
Route::post('/personas/registrar','PersonaController@store');
Route::put('/personas/actualizar','PersonaController@update');
Route::get('/personas/selectPersona','PersonaController@selectPersona');

