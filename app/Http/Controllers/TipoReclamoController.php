<?php

namespace App\Http\Controllers;

use App\FlujoTrabajo;
use App\Prioridad;
use App\Requisito;
use App\TipoReclamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoReclamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoReclamos = TipoReclamo::all() ;
        $flujosTrabajos = FlujoTrabajo::all() ;
        $prioridades = Prioridad::all() ;
        $requisitos = Requisito::all() ;
        return view('tipoReclamos.index', compact('tipoReclamos' , 'flujosTrabajos' , 'prioridades' , 'requisitos')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipoReclamo = new TipoReclamo();
        $tipoReclamo->fill($request->only(['nombre' , 'detalle' , 'trabajo' , 'prioridad_id'])) ;
        if($request->trabajo){
            $tipoReclamo->flujoTrabajo_id = $request->flujoTrabajo_id ;
        }
        $tipoReclamo->save();
        $tipoReclamo->requisitos()->sync($request->input('requisitos',[])) ;
        return redirect('/tipoReclamos')->with('confirmar' , 'bien') ;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoReclamo  $tipoReclamo
     * @return \Illuminate\Http\Response
     */
    public function show(TipoReclamo $tipoReclamo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoReclamo  $tipoReclamo
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoReclamo $tipoReclamo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoReclamo  $tipoReclamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tipoRec = TipoReclamo::find($id) ;
        $tipoRec->fill($request->only(['nombre' , 'detalle' , 'trabajo' , 'prioridad_id' , 'flujoTrabajo_id'])) ;
        if($request->trabajo){
            $tipoRec->flujoTrabajo_id = $request->flujoTrabajo_id ;
        }
        $tipoRec->update();
        $tipoRec->requisitos()->sync($request->input('requisitos',[])) ;
        return redirect('/tipoReclamos')->with('confirmar' , 'bien') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoReclamo  $tipoReclamo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoReclamo = TipoReclamo::find($id) ;
        try{
            $tipoReclamo->delete() ;
            return redirect()->back()->with('borrado' , 'ok') ;

        }catch(Exception $e){
            alert()->error('No es posible eliminar el tipo de reclamo' , 'Error') ;
            return redirect('/almacenes') ;
        }
    }

    public function cargarRequisitos($id){
        return DB::table('requisito_tipo_reclamo')->join('requisitos', 'requisito_tipo_reclamo.requisito_id' , '=', 'requisitos.id')->select('requisitos.id', 'requisitos.nombre')->where('requisito_tipo_reclamo.tipo_reclamo_id', $id)->get();
    }
}
