<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zona;
use App\Direccion ;
use App\User ;
use Caffeinated\Shinobi\Models\Role;
use Exception;
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
        $zonas = Zona::all() ;
        return view('usuarios.registro' ,  compact('roles' ,'zonas','user')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $direccion = new Direccion();
        $direccion->zona_id = $request->zona_id ;
        $direccion->calle = $request->calle ;
        $direccion->altura = $request->altura ;
        $direccion->save() ;

        $user->name = $request->name ;
        $user->apellido = $request->apellido ;
        $user->dni = $request->dni ;
        $user->telefono = $request->telefono ;
        $user->fecha_ingreso = $request->fecha_ingreso;
        $user->direccion_id = $direccion->id ;
        $user->email = $request->email ;
        if($request->urlFoto != null){
            $file = $request->file('urlFoto') ;
            $name = time().$user->name.$user->apellido.'.png';
            $file->move(public_path('/img/perfiles/') , $name) ;
            $user->urlFoto = $name ;
        }
        $user->password = Hash::make('123456789');
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
    public function show(User $user)
    {
        //$user = User::find($id) ;
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
        $zonas = Zona::all() ;
        return view('usuarios.edit' , compact('user','roles','zonas'));
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

        if($request->urlFoto != null){
            $file = $request->file('urlFoto') ;
            $name = time().$user->name.$user->apellido.'.png';
            $file->move(public_path('/img/perfiles/') , $name) ;
            $user->urlFoto = $name ;
        }

        $direccion = $user->direccion ;
        $direccion->fill($request->only(['zona_id' , 'calle' , 'altura'])) ;
        $direccion->save() ;
        $user->update() ;
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
            try{
                $user->delete() ;
                return redirect('/users');
            }catch(Exception $e){
                report($e) ;
                return redirect()->back()->with('cancelar' , 'asdf') ;
            }
        }

    }
}
