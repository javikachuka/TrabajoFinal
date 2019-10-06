<?php

namespace App\Http\Controllers;

use App\Socio;
use App\Barrio;
use App\Direccion;
use App\Zona;
use Exception;
use Illuminate\Http\Request;

class SocioController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socios = Socio::all();
        $zonas = Zona::all() ;
        return view('socios.index',compact('socios','zonas')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barrios = Barrio::all() ;

        return view('socios.registro',compact('barrios')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validar();
        $direccion = new Direccion() ;
        $direccion->zona_id = $request->input('zona_id') ;
        $direccion->calle = $request->input('calle') ;
        $direccion->altura = $request->input('altura') ;
        $direccion->save() ;

        $socio = new Socio() ;
        $socio->apellido = $request->input('apellido') ;
        $socio->nombre = $request->input('nombre');
        $socio->dni = $request->input('dni');
        $socio->nro_conexion = $request->input('nro_conexion');
        $socio->direccion_id = $direccion->id ; ;
        $socio->save() ;
        return redirect()->back()->with('confirmar', 'ok');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $socio = Socio::find($id) ;
        return view('socios.show',compact('socio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $socio = Socio::find($id) ;
        $barrios = Barrio::all() ;
        return view('socios.edit' , compact('socio','barrios')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Socio $socio)
    {
        // $this->validar();
        $socio->fill($request->all());
        $direccion = $socio->direccion ;
        $direccion->fill($request->all()) ;
        $socio->save() ;
        $direccion->save() ;

        return redirect()->back()->with('confirmar', 'ok') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Socio $socio)
    {
        try{
            $socio->delete();
            return redirect()->back()->with('borrado', 'ok');
        }catch(Exception $e){
            alert()->error('No se pudo borrar al socio', 'Error') ;
            return redirect()->back() ;
        }
    }

    public function validar(){
        $data = request()->validate([
            'nombre' => 'required' ,
            'apellido' => 'required' ,
            'dni' => 'required' ,
            'nro_conexion' => 'required|unique:socios,nro_conexion',
        ],[
            'nro_conexion.unique' => 'El numero de conexion ya esta asignado a un socio' ,
        ]);
    }
}
