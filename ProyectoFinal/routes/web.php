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
    return view('vw_principal.principal');
})->name('home');

Route::resource('empleados' , 'EmpleadoController') ;

Route::resource('reclamos','ReclamoController') ;

Route::get('socios','SocioController@index')->name('socios.index') ;

Route::get('socios/create','SocioController@create')->name('socios.create') ;

Route::get('socios/{id}','SocioController@show')->name('socios.show') ;

Route::get('socios/{id}/edit','SocioController@edit')->name('socios.edit') ;

Route::put('socios/{socio}' , 'SocioController@update')->name('socios.update') ;







