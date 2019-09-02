<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barrio;
use App\Rol;
use App\Domicilio ;
use App\User ;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all() ;
        return view('vw_usuarios.index' , compact('usuarios')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User() ;
        $roles = Rol::all() ;
        $barrios = Barrio::all() ;
        return view('vw_usuarios.registro' ,  compact('roles' ,'barrios','user')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $domicilio = new Domicilio();
        $domicilio->barrio_id = $request->barrio_id ;
        $domicilio->calle = $request->calle ;
        $domicilio->altura = $request->altura ;
        $domicilio->save() ;

        $user->name = $request->name ;
        $user->apellido = $request->apellido ;
        $user->dni = $request->dni ;
        $user->rol_id = $request->rol_id;
        $user->telefono = $request->telefono ;
        $user->fecha_ingreso = $request->fecha_ingreso;
        $user->domicilio_id = $domicilio->id ;
        $user->email = $request->email ;
        $user->password = Hash::make($request->password) ;
        $user->save() ;

        return redirect('/users') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id) ;
        return $user ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id) ;
        $roles = Rol::all() ;
        $barrios = Barrio::all() ;
        return view('vw_usuarios.edit' , compact('user','roles','barrios'));
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
        $user = User::find($id) ;
        $user->fill($request->only(['name' , 'apellido' , 'dni' , 'fecha_ingreso' ,'rol_id' , 'telefono' , 'email'])) ;
        $domicilio = $user->domicilio ;
        $domicilio->fill($request->only(['barrio_id' , 'calle' , 'altura'])) ;
        $domicilio->save() ;
        $user->save() ;
        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id) ;
        if($user != null){
            $user->delete() ;
        }
        return redirect('/users');

    }
}
