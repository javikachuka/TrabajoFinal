<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/reclamos/create/requisitos/{id}', 'TipoReclamoController@cargarRequisitos')->name('tipoReclamos.cargarRequisitos') ;

Route::get('turnos/asignacion/{id}' , 'TurnoController@obtenerTurnos')->name('turnos.obtener') ;

Route::get('asistencias/{id}', 'AsistenciaController@obtener')->name('asistencias.obtener');


Route::get('obtenerMedida/{id}', 'ProductoController@obtenerMedida')->name('productos.obtenerMedida');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
