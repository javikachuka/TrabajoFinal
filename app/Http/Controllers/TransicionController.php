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
    public function create($id)
    {
        $estados = Estado::all() ;
        $flujoTrabajo = FlujoTrabajo::find($id) ;
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

            $transicion = new Transicion() ;
            foreach($flujoTrabajo->transiciones as $tran){
                if(($tran->estadoInicial->id == $request->estadoInicial_id) && ($tran->estadoFinal->id == $request->estadoFinal_id)){
                    alert()->error('Ya existe una transicion con el estado inicial y final correspondiente' , 'error')->persistent() ;
                    return redirect()->back();
                }
            }
            $transicion->flujoTrabajo_id = $flujoTrabajo->id ;
            $transicion->nombre = $request->nombre ;
            $transicion->estadoInicial_id = $request->estadoInicial_id;
            if($transicion->asignarEstadoFinal($request->estadoFinal_id) ){
                $transicion->orden = sizeof($flujoTrabajo->transiciones)+1 ;
                $transicion->save() ;
            }
            else{
                alert()->error('El estado final debe ser distinto al inicial' , 'error')->persistent() ;
                return redirect()->back();
            }

            return redirect()->back()->with('confirmar' , 'asdf') ;

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
    public function destroy($id)
    {
        $transicion = Transicion::find($id) ;

        $transicion->delete() ;
        return redirect()->back()->with('borrado' , 'ok') ;
    }

}
