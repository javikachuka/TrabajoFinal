<?php

namespace App\Http\Controllers;

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

        return redirect()->route('transiciones.create' , $flujoTrabajo) ;


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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FlujoTrabajo  $flujoTrabajo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FlujoTrabajo $flujoTrabajo)
    {
        //
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
