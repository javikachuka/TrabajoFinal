<?php

namespace App\Http\Controllers;

use App\Estado;
use App\FlujoTrabajo;
use App\Reclamo;
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

        $estados = Estado::all() ;
        // $flujosTrabajo = FlujoTrabajo::all() ;
        return view('transiciones.index' , compact( 'estados')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FlujoTrabajo $flujoTrabajo)
    {

        $estados = Estado::all() ;
        return view('transiciones.index' , compact( 'estados','flujoTrabajo')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $flujoTrabajo_id)
    {
        $flujoTrabajo = FlujoTrabajo::find($flujoTrabajo_id) ;
        for($i = 0 ; $i < sizeof($request->nombre) ; $i++){
            $transicion = new Transicion() ;
            foreach($flujoTrabajo->transiciones as $tran){
                if(($tran->estadoInicial->id == $request->estadoInicial_id[$i]) && ($tran->estadoFinal->id == $request->estadoFinal_id[$i])){
                    return redirect()->back()->with('cancelar' , 'asdf') ;
                }
            }
            $transicion->flujoTrabajo_id = $flujoTrabajo->id ;
            $transicion->nombre = $request->nombre[$i] ;
            $transicion->estadoInicial_id = $request->estadoInicial_id[$i];
            if($transicion->asignarEstadoFinal($request->estadoFinal_id[$i]) ){
                $transicion->orden = sizeof($flujoTrabajo->transiciones)+1 ;
                $transicion->save() ;
            }
            else{
                return redirect()->back()->with('cancelar' , 'asdf') ;  ;
            }
        }
        return redirect('/flujoTrabajos')->with('confirmar' , 'asdf') ;

        // $transicion->nombre = $request->nombre ;
        // $transicion->flujoTrabajo = $request->flujoTrabajo ;
        // $transicion->asignarEstadoInicial($request->estadoInicial );
        // $transiciones = Transicion::all() ;

        // if($transicion->asignarEstadoFinal($request->estadoFinal )){
        //     foreach($transiciones as $tran){
        //         if(($tran->estadoInicial == $transicion->estadoInicial) && ($tran->estadoFinal == $transicion->estadoFinal)){
        //             return redirect('/transiciones')->with('message', ':(') ;
        //         }
        //     }
        //     $transicion->save() ;
        //     return redirect('/transiciones')->with('message', 'Success!') ;
        // }

    }

    public function ordenar(Request $request){
        return $request ;
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
        return $transicion ;
        $transicion->delete() ;
        return redirect()->back() ;
    }

}
