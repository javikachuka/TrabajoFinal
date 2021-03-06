<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zona;
use App\Direccion;
use App\User;
use Caffeinated\Shinobi\Models\Role;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        $roles = Role::all();
        return view('usuarios.index', compact('usuarios', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $roles = Role::all()->pluck('name', 'id');
        $zonas = Zona::all();
        return view('usuarios.registro',  compact('roles', 'zonas', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:190',
            'apellido' => 'required|max:190',
            'email' => 'required|email|unique:users,email',
            'dni' => 'required|string|min:10',
            'telefono' => 'required|max:15',
            'altura' => 'required|max:10' ,
            'calle' => 'required|string|max:190' ,
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $direccion = new Direccion();
        $direccion->zona_id = $request->zona_id;
        $direccion->calle = $request->calle;
        $direccion->altura = $request->altura;
        $direccion->save();

        $user->name = $request->name;
        $user->apellido = $request->apellido;
        $user->dni = $request->dni;
        $user->telefono = $request->telefono;
        $user->fecha_ingreso = $request->fecha_ingreso;
        $user->direccion_id = $direccion->id;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($request->urlFoto != null) {
            $file = $request->file('urlFoto');
            $name = time() . $user->name . $user->apellido . '.png';
            $file->move(public_path('/img/perfiles/'), $name);
            $user->urlFoto = $name;
        }
        // $user->password = Hash::make('123456789');
        $user->save();

        // $user = User::create($request->all()) ;
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('users.index')->with('confirmar', 'ok');
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
        return view('usuarios.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all()->pluck('name', 'id');
        $zonas = Zona::all();
        return view('usuarios.edit', compact('user', 'roles', 'zonas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:190',
            'apellido' => 'required|max:190',
            'email' => 'required|email|unique:users,email,'. $id,
            'dni' => 'required|string|min:10',
            'telefono' => 'required|max:15',
            'altura' => 'required|max:10' ,
            'calle' => 'required|string|max:190' ,
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        $user->fill($request->only(['name', 'apellido', 'dni', 'fecha_ingreso', 'telefono', 'email']));

        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }

        if ($request->urlFoto != null) {
            $file = $request->file('urlFoto');
            $name = time() . $user->name . $user->apellido . '.png';
            $file->move(public_path('/img/perfiles/'), $name);
            $user->urlFoto = $name;
        }

        $direccion = $user->direccion;
        $direccion->fill($request->only(['zona_id', 'calle', 'altura']));
        $direccion->save();
        $user->update();
        $user->roles()->sync($request->input('roles', []));
        return redirect()->route('users.index')->with('confirmar', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user != null) {
            try {
                if (!$user->id == 1) {
                    $user->delete();
                    return redirect('/users');
                } else {
                    alert()->error('No es posible eliminar al administrador', 'Error');
                    return redirect()->back();
                }
            } catch (Exception $e) {
                report($e);
                return redirect()->back()->with('cancelar', 'asdf');
            }
        }
    }
}
