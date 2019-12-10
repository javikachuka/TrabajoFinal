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

Route::get('obtenerCantidad/{idProd}/{idAlmacen}/{cantidad}', 'ProductoController@tieneCantidadDisponible')->name('productos.tieneCantidadDisponible');

Route::get('obtenerConexiones/{id}', 'SocioController@obtenerConexiones')->name('socios.obtenerConexiones');

Route::get('obtenerDni/{id}', 'SocioController@obtenerDni')->name('socios.obtenerDni');

Route::get('comprobarFin/{trabajo}/{fecha}/{hora}', 'TrabajoController@comprobarFin')->name('trabajos.comprobarFin');

Route::get('comprobarDni/{dni}/{id}', 'AsistenciaController@comprobarDni')->name('asistencias.comprobarDni');


Route::get('obtenerAlmacenes/{id}', 'ProductoController@obtenerAlmacenes')->name('productos.obtenerAlmacenes');


Route::get('obtenerDireccion/{id}/{num}', 'SocioController@obtenerDireccion')->name('socios.obtenerDireccion');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
