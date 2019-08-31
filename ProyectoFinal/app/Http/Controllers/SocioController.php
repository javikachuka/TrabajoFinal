<?php

namespace App\Http\Controllers;

use App\Socio;
use App\Barrio;
use App\Domicilio;
use Illuminate\Http\Request;

class SocioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socios = Socio::all();
        $domicilios = Domicilio::all();
        return view('vw_socios.index',compact('socios','domicilios')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barrios = Barrio::all() ;

        return view('vw_socios.registro',compact('barrios')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $domicilio = new Domicilio() ;
        $domicilio->barrio_id = $request->input('domicilio') ;
        $domicilio->calle = $request->input('calle') ;
        $domicilio->altura = $request->input('altura') ;
        $domicilio->save() ;

        $socio = new Socio() ;
        $socio->apellido = $request->input('apellido') ;
        $socio->nombre = $request->input('nombre');
        $socio->dni = $request->input('dni');
        $socio->nro_conexion = $request->input('nro_conexion');
        $socio->domicilio_id = $domicilio->id ; ;
        $socio->save() ;
        return redirect('/socios');


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
        return view('vw_socios.show',compact('socio'));
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
        return view('vw_socios.edit' , compact('socio','barrios')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $socio = Socio::find($id) ;
        $socio->fill($request->all());
        $domicilio = $socio->domicilio ;
        $domicilio->fill($request->all()) ;
        $socio->save() ;
        $domicilio->save() ;

        return redirect('/socios') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Socio $socio)
    {
        //
    }
}
