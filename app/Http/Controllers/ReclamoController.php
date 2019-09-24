<?php

namespace App\Http\Controllers;

use App\HistorialEstado;
use App\Reclamo;
use Illuminate\Http\Request;
use App\TipoReclamo ;
use App\Socio ;
use App\Trabajo;

class ReclamoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reclamos = Reclamo::all();

        return view('reclamos.index',compact('reclamos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reclamo = new Reclamo() ;
        $socios = Socio::all() ;
        $tipos_reclamos = TipoReclamo::all() ;
        $reclamos = Reclamo::all() ;
        return view('reclamos.create' , compact('reclamo' ,'reclamos' , 'socios' , 'tipos_reclamos')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Reclamo $reclamo)
    {
        return $request ;

        $reclamo->fill($request->only(['socio_id' ,'tipoReclamo_id' , 'fecha' , 'detalle'])) ;
        $reclamo->user_id = auth()->user()->id ;
        $reclamo->save() ;
        if($reclamo->tipoReclamo->trabajo == true){ // hay un atributo que es boolean (trabajo) y me dice si el reclamo conlleva o no un trabajo
            $trabajo = new Trabajo() ;
            $trabajo->fecha = $reclamo->fecha ;
            $trabajo->estado_id = $reclamo->tipoReclamo->flujoTrabajo->getEstadoInicial() ;
            $trabajo->save() ;
            $reclamo->trabajo_id = $trabajo->id ;
            $reclamo->update() ;
            $historial = new HistorialEstado();
            $historial->reclamo_id = $reclamo->id ;
            $historial->estado_id = $trabajo->estado_id ;
            $historial->save() ;
        }
        return redirect('/reclamos')->with('confirmar' , 'bien') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function show(Reclamo $reclamo)
    {
        return view('reclamos.show' , compact('reclamo')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function edit(Reclamo $reclamo)
    {
        $socios = Socio::all() ;
        $tipos_reclamos = TipoReclamo::all() ;
        $reclamos = Reclamo::all() ;
        return view('reclamos.edit' , compact('reclamo' , 'socios' , 'tipos_reclamos' , 'reclamos')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reclamo $reclamo)
    {
        $reclamo->fill($request->only(['socio_id' ,'tipoReclamo_id' , 'fecha' , 'detalle'])) ;
        $reclamo->update();
        return redirect('/reclamos')->with('confirmar' , 'bien') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reclamo $reclamo)
    {
        //
    }


}
