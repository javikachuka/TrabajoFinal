<?php

namespace App\Http\Controllers;

use App\Estado;
use App\FlujoTrabajo;
use Exception;
use Illuminate\Http\Request;

class FlujoTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flujoTrabajos = FlujoTrabajo::all() ;


        return view('flujoTrabajo.index' , compact('flujoTrabajos')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $flujoTrabajo = new FlujoTrabajo() ;
        return view('flujoTrabajo.create' , compact('flujoTrabajo')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , FlujoTrabajo $flujoTrabajo)
    {
        $this->validar();
        $flujoTrabajo->fill($request->all()) ;
        $flujoTrabajo->save() ;
        return redirect()->route('transiciones.create' , $flujoTrabajo->id) ;


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FlujoTrabajo  $flujoTrabajo
     * @return \Illuminate\Http\Response
     */
    public function show(FlujoTrabajo $flujoTrabajo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FlujoTrabajo  $flujoTrabajo
     * @return \Illuminate\Http\Response
     */
    public function edit(FlujoTrabajo $flujoTrabajo)
    {

        return redirect()->route('transiciones.create', $flujoTrabajo->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FlujoTrabajo  $flujoTrabajo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $flujoTrabajo_id)
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FlujoTrabajo  $flujoTrabajo
     * @return \Illuminate\Http\Response
     */
    public function destroy(FlujoTrabajo $flujoTrabajo)
    {
        try{
            $flujoTrabajo->delete() ;
            return redirect()->back()->with('confirmar' , 'asd') ;
        }catch(Exception $e){
            return redirect()->back()->with('cancelar' , 'asdf');
        }

    }

    public function validar(){
        $data = request()->validate([
            'nombre' => 'required|unique:flujo_trabajos,nombre' ,
        ]);
    }
}
