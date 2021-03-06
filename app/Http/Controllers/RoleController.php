<?php

namespace App\Http\Controllers;

use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all() ;
        $permisos= Permission::all() ;
        return view('roles.index', compact('roles', 'permisos')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rol = new Role() ;
        $permisos = Permission::all()->pluck('name' , 'id') ;
        return view('roles.create' , compact('rol' , 'permisos')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Role $rol)
    {
        $rol->fill($request->all()) ;
        $rol->save() ;
        $rol->permissions()->sync($request->input('permisos',[])) ;
        if($request->special != ""){
            $rol->permissions()->sync($request->input('special')) ;
        }
        return redirect('/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rol = Role::find($id) ;
        $permisos = Permission::all()->pluck('name' , 'id') ;

        return view('roles.edit' , compact('rol' , 'permisos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id)
    {
        $rol = Role::find($id) ;
        $rol->fill($request->all()) ;
        $rol->save() ;
        $rol->permissions()->sync($request->input('permisos',[])) ;
        return redirect('/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rol = Role::find($id) ;
        if(!$rol->users->isEmpty()){
            alert()->error('No es posible eliminar el rol debido a que tiene asociado usuarios', 'Error')->persistent();
            return redirect()->back() ;
        }
        if($rol->name == 'ADMIN'){
            alert()->error('No es posible eliminar el rol admin', 'Error')->persistent();
            return redirect()->back() ;
        }

        $rol->delete() ;
        return redirect()->back()->with('borrado' , 'ok') ;

    }
}
