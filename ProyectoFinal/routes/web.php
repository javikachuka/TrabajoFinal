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

Route::get('/home', function () {
    return view('vw_principal.principal');
}) ;

Route::get('/', function(){
    return view('vw_principal.login') ;
}) ;

Route::resource('reclamos','ReclamoController') ;

// Route::get('users','UserController@index')->name('users.index') ;
// Route::get('users/create','UserController@create')->name('users.create') ;
// Route::post('users','UserController@store')->name('users.store') ;
// Route::get('users/{id}','UserController@show')->name('users.show') ;
// Route::get('users/{id}/edit' , 'UserController@edit')->name('users.edit') ;
// Route::put('users/{user}' , 'UserController@update')->name('users.update') ;
// Route::delete('users/{id}' , 'UserController@destroy')->name('users.destroy');

Route::resource('users' , 'UserController') ; 

Route::get('socios','SocioController@index')->name('socios.index') ;
Route::get('socios/create','SocioController@create')->name('socios.create') ;
Route::post('socios','SocioController@store')->name('socios.store');
Route::get('socios/{id}','SocioController@show')->name('socios.show') ;
Route::get('socios/{id}/edit','SocioController@edit')->name('socios.edit') ;
Route::put('socios/{socio}' , 'SocioController@update')->name('socios.update') ;



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
