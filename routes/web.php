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
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function(){
    return view('principal.login') ;
}) ;
Route::get('/prueba', function(){
    return view('prueba') ;
}) ;


Route::get('/proveedorPDF', 'PdfController@proveedorPDF')->name('proveedor.pdf') ;
Route::get('/movimientosPDF', 'PdfController@movimientosPDF')->name('movimientos.pdf') ;



Route::middleware(['auth'])->group(function(){

    //reclamos
    Route::get('reclamos','ReclamoController@index')->name('reclamos.index')->middleware('permission:reclamos_index')  ;
    Route::get('reclamos/create','ReclamoController@create')->name('reclamos.create')->middleware('permission:reclamos_create')  ;
    Route::post('reclamos','ReclamoController@store')->name('reclamos.store')->middleware('permission:reclamos_store')  ;
    Route::get('reclamos/{reclamo}','ReclamoController@show')->name('reclamos.show')->middleware('permission:reclamos_show')  ;
    Route::get('reclamos/{reclamo}/edit' , 'ReclamoController@edit')->name('reclamos.edit')->middleware('permission:reclamos_edit')  ;
    Route::put('reclamos/{user}' , 'ReclamoController@update')->name('reclamos.update')->middleware('permission:reclamos_update')  ;
    Route::delete('reclamos/{reclamo}' , 'ReclamoController@destroy')->name('reclamos.destroy')->middleware('permission:reclamos_destroy') ;


    //users
    Route::get('users','UserController@index')->name('users.index')->middleware('permission:users_index')  ;
    Route::get('users/create','UserController@create')->name('users.create')->middleware('permission:users_create')  ;
    Route::post('users','UserController@store')->name('users.store')->middleware('permission:users_store')  ;
    Route::get('users/{user}','UserController@show')->name('users.show')->middleware('permission:users_show')  ;
    Route::get('users/{id}/edit' , 'UserController@edit')->name('users.edit')->middleware('permission:users_edit')  ;
    Route::put('users/{user}' , 'UserController@update')->name('users.update')->middleware('permission:users_update')  ;
    Route::delete('users/{id}' , 'UserController@destroy')->name('users.destroy')->middleware('permission:users_destroy') ;


    //proveedores
    Route::get('proveedores','ProveedorController@index')->name('proveedores.index')->middleware('permission:proveedores_index')  ;
    Route::get('proveedores/create','ProveedorController@create')->name('proveedores.create')->middleware('permission:proveedores_create')  ;
    Route::post('proveedores','ProveedorController@store')->name('proveedores.store')->middleware('permission:proveedores_store')  ;
    Route::get('proveedores/{id}','ProveedorController@show')->name('proveedores.show')->middleware('permission:proveedores_show')  ;
    Route::get('proveedores/{id}/edit' , 'ProveedorController@edit')->name('proveedores.edit')->middleware('permission:proveedores_edit')  ;
    Route::put('proveedores/{proveedor}' , 'ProveedorController@update')->name('proveedores.update')->middleware('permission:proveedores_update')  ;
    Route::delete('proveedores/{id}' , 'ProveedorController@destroy')->name('proveedores.destroy')->middleware('permission:proveedores_destroy') ;

    //productos
    Route::get('productos','ProductoController@index')->name('productos.index')->middleware('permission:productos_index')  ;
    Route::get('productos/create','ProductoController@create')->name('productos.create')->middleware('permission:productos_create')  ;
    Route::post('productos','ProductoController@store')->name('productos.store')->middleware('permission:productos_store')  ;
    Route::get('productos/{producto}','ProductoController@show')->name('productos.show')->middleware('permission:productos_show')  ;
    Route::get('productos/{id}/edit' , 'ProductoController@edit')->name('productos.edit')->middleware('permission:productos_edit')  ;
    Route::put('productos/{producto}' , 'ProductoController@update')->name('productos.update')->middleware('permission:productos_update')  ;
    Route::delete('productos/{producto}' , 'ProductoController@destroy')->name('productos.destroy')->middleware('permission:productos_destroy') ;

    //socios
    Route::resource('socios' , 'SocioController') ;

    //roles
    Route::get('roles','RoleController@index')->name('roles.index')->middleware('permission:roles_index')  ;
    Route::get('roles/create','RoleController@create')->name('roles.create')->middleware('permission:roles_create')  ;
    Route::post('roles','RoleController@store')->name('roles.store')->middleware('permission:roles_store')  ;
    Route::get('roles/{id}','RoleController@show')->name('roles.show')->middleware('permission:roles_show')  ;
    Route::get('roles/{id}/edit','RoleController@edit')->name('roles.edit')->middleware('permission:roles_edit')  ;
    Route::put('roles/{roles}' , 'RoleController@update')->name('roles.update')->middleware('permission:roles_update')  ;
    Route::delete('roles/{id}' , 'RoleController@destroy')->name('roles.destroy')->middleware('permission:roles_destroy') ;

    //permisos
    Route::get('permisos','PermissionController@index')->name('permisos.index')->middleware('permission:permisos_index')  ;
    Route::get('permisos/create', 'PermissionController@create')->name('permisos.create')->middleware('permission:permisos_create')  ;
    Route::post('permisos','PermissionController@store')->name('permisos.store')->middleware('permission:permisos_store')  ;
    Route::get('permisos/{permiso}', 'PermissionController@show')->name('permisos.show')->middleware('permission:permisos_show')  ;
    Route::get('permisos/{permiso}/edit','PermissionController@edit')->name('permisos.edit')->middleware('permission:permisos_edit')  ;
    Route::put('permisos/{id}' , 'PermissionController@update')->name('permisos.update')->middleware('permission:permisos_update')  ;
    Route::delete('permisos/{permiso}' , 'PermissionController@destroy')->name('permisos.destroy')->middleware('permission:permisos_destroy') ;


    //Flujos de Trabajo
    Route::get('flujoTrabajos','FlujoTrabajoController@index')->name('flujoTrabajos.index') ;
    Route::get('flujoTrabajos/create', 'FlujoTrabajoController@create')->name('flujoTrabajos.create') ;
    Route::post('flujoTrabajos', 'FlujoTrabajoController@store')->name('flujoTrabajos.store') ;
    Route::delete('flujoTrabajos/{flujoTrabajo}' , 'FlujoTrabajoController@destroy')->name('flujoTrabajos.destroy') ;

    //transiciones
    Route::get('transiciones','TransicionController@index')->name('transiciones.index') ;
    Route::get('transiciones/create/{flujoTrabajo}', 'TransicionController@create')->name('transiciones.create') ;
    Route::post('transiciones/{id}', 'TransicionController@store')->name('transiciones.store') ;
    // Route::post('transiciones/orden', 'TransicionController@ordenar')->name('transiciones.ordenar') ;
    Route::get('transiciones/{transicion}', 'TransicionController@show')->name('transicion.show')->middleware('permission:transiciones_show')  ;
    Route::get('transiciones/{transicion}/edit','TransicionController@edit')->name('transicion.edit')->middleware('permission:transiciones_edit')  ;
    Route::put('transiciones/{transicion}' , 'TransicionController@update')->name('transicion.update')->middleware('permission:transiciones_update')  ;
    Route::delete('transiciones/{transicion}' , 'TransicionController@destroy')->name('transicion.destroy')->middleware('permission:transiciones_destroy') ;



    //estados
    Route::get('estados/create', 'EstadoController@create')->name('estados.create') ;
    Route::post('estados', 'EstadoController@store')->name('estados.store') ;


    //movimientos
    Route::get('movimientos','MovimientoController@index')->name('movimientos.index') ;
    Route::get('movimientos/createIngreso', 'MovimientoController@createIngreso')->name('movimientos.createIngreso') ;
    Route::get('movimientos/createTransferencia', 'MovimientoController@createTransferencia')->name('movimientos.createTransferencia') ;
    Route::post('movimientos/ingreso', 'MovimientoController@storeIngreso')->name('movimientos.storeIngreso') ;
    Route::post('movimientos/transferencia', 'MovimientoController@storeTransferencia')->name('movimientos.storeTransferencia') ;
    Route::get('movimientos/{movimiento}/edit','MovimientoController@edit')->name('movimientos.edit')->middleware('permission:movimientos_edit')  ;

    // Route::post('movimientos/ingreso','MovimientoController@ingreso')->name('movimientos.ingreso') ;
    // Route::post('movimientos/egreso','MovimientoController@egreso')->name('movimientos.egreso') ;

    //trabajos

    Route::get('trabajos','TrabajoController@index')->name('trabajos.index')->middleware('permission:trabajos_index')  ;
    Route::get('trabajos/create', 'TrabajoController@create')->name('trabajos.create')->middleware('permission:trabajos_create')  ;
    Route::post('trabajos','TrabajoController@store')->name('trabajos.store')->middleware('permission:trabajos_store')  ;
    Route::get('trabajos/{trabajo}', 'TrabajoController@show')->name('trabajos.show')->middleware('permission:trabajos_show')  ;
    Route::get('trabajos/{trabajo}/edit','TrabajoController@edit')->name('trabajos.edit')->middleware('permission:trabajos_edit')  ;
    Route::put('trabajos/{id}' , 'TrabajoController@update')->name('trabajos.update')->middleware('permission:trabajos_update')  ;
    Route::delete('trabajos/{trabajo}' , 'TrabajoController@destroy')->name('trabajos.destroy')->middleware('permission:trabajos_destroy') ;


    //almacenes
    Route::get('almacenes','AlmacenController@index')->name('almacenes.index')->middleware('permission:almacenes_index')  ;
    Route::get('almacenes/create', 'AlmacenController@create')->name('almacenes.create')->middleware('permission:almacenes_create')  ;
    Route::post('almacenes','AlmacenController@store')->name('almacenes.store')->middleware('permission:almacenes_store')  ;
    Route::get('almacenes/{almacen}', 'AlmacenController@show')->name('almacenes.show')->middleware('permission:almacenes_show')  ;
    Route::get('almacenes/{almacen}/edit','AlmacenController@edit')->name('almacenes.edit')->middleware('permission:almacenes_edit')  ;
    Route::put('almacenes/{almacen}' , 'AlmacenController@update')->name('almacenes.update')->middleware('permission:almacenes_update')  ;
    Route::delete('almacenes/{id}' , 'AlmacenController@destroy')->name('almacenes.destroy')->middleware('permission:almacenes_destroy') ;



}) ;






// Route::get('socios','SocioController@index')->name('socios.index') ;
// Route::get('socios/create','SocioController@create')->name('socios.create') ;
// Route::post('socios','SocioController@store')->name('socios.store');
// Route::get('socios/{id}','SocioController@show')->name('socios.show') ;
// Route::get('socios/{id}/edit','SocioController@edit')->name('socios.edit') ;
// Route::put('socios/{socio}' , 'SocioController@update')->name('socios.update') ;




