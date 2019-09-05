<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barrio;
use App\Domicilio ;
use App\User ;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

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
        $roles = Role::all() ;
        return view('usuarios.index' , compact('usuarios','roles')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User() ;
        $roles = Role::all()->pluck('name' , 'id') ;
        $barrios = Barrio::all() ;
        return view('usuarios.registro' ,  compact('roles' ,'barrios','user')) ;
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
        $user->telefono = $request->telefono ;
        $user->fecha_ingreso = $request->fecha_ingreso;
        $user->domicilio_id = $domicilio->id ;
        $user->email = $request->email ;
        $user->password = Hash::make('12345678');
        $user->save() ;

        // $user = User::create($request->all()) ;
        $user->roles()->sync($request->input('roles',[])) ;

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
        return view('usuarios.show' , compact('user')) ;
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
        $roles = Role::all()->pluck('name' , 'id') ;
        $barrios = Barrio::all() ;
        return view('usuarios.edit' , compact('user','roles','barrios'));
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
        $user->fill($request->only(['name' , 'apellido' , 'dni' , 'fecha_ingreso' , 'telefono' , 'email'])) ;
        $domicilio = $user->domicilio ;
        $domicilio->fill($request->only(['barrio_id' , 'calle' , 'altura'])) ;
        $domicilio->save() ;
        $user->save() ;
        $user->roles()->sync($request->input('roles',[])) ;
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
