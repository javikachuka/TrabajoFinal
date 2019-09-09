<?php

namespace App\Http\Controllers;

use App\Estado;
use App\FlujoTrabajo;
use App\Transicion;
use Illuminate\Cache\RetrievesMultipleKeys;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class TransicionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flujosTrabajo = FlujoTrabajo::all() ;
        $estados = Estado::all() ;
        return view('transiciones.index' , compact('flujosTrabajo' , 'estados')) ;
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
    public function store(Request $request , Transicion $transicion)
    {
        $transicion->nombre = $request->nombre ;
        $transicion->flujoTrabajo = $request->flujoTrabajo ;
        $transicion->asignarEstadoInicial($request->estadoInicial );
        $transiciones = Transicion::all() ;

        if($transicion->asignarEstadoFinal($request->estadoFinal )){
            foreach($transiciones as $tran){
                if(($tran->estadoInicial == $transicion->estadoInicial) && ($tran->estadoFinal == $transicion->estadoFinal)){
                    return redirect('/transiciones')->with('message', ':(') ;
                }
            }
            $transicion->save() ;
            return redirect('/transiciones')->with('message', 'Success!') ;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transicion  $transicion
     * @return \Illuminate\Http\Response
     */
    public function show(Transicion $transicion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transicion  $transicion
     * @return \Illuminate\Http\Response
     */
    public function edit(Transicion $transicion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transicion  $transicion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transicion $transicion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transicion  $transicion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transicion $transicion)
    {
        //
    }

}
