<?php

namespace App\Http\Controllers;

use App\Estado;
use Exception;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados = Estado::all() ;
        return view('estados.index' , compact('estados')) ;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estado = new Estado() ;
        return view('estados.create' , compact('estado')) ;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Estado $estado)
    {
        $this->validar();
        $estado->fill($request->all());
        $estado->save() ;
        return redirect()->back()->with('confirmar' , 'bien') ;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function show(Estado $estado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function edit(Estado $estado)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $estado = Estado::find($id);
        $this->validar();
        $estado->fill($request->all());
        $estado->update() ;
        return redirect()->back()->with('confirmar' , 'bien') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estado $estado)
    {
        try{
            $estado->delete() ;
            return redirect()->back()->with('confirmar' , 'borrado') ;
        }catch(Exception $e){
            alert()->error('No es posible eliminar el estado' , 'Error') ;
            return redirect('/estados') ;
        }
    }

    public function validar(){
        return  request()->validate([
            'nombre' => 'required|unique:estados' ,
        ]);
    }

}
