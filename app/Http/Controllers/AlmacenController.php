<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Direccion;
use App\Zona;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $almacenes = Almacen::all() ;
        $zonas = Zona::all() ;
        return view('almacenes.index' , compact('almacenes' , 'zonas'));
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
        $validator = Validator::make($request->all(), [
            'denominacion' => 'required|unique:almacenes,denominacion',
        ],['denominacion.unique' => 'El almacen ya existe']);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator) ;
        }

        $direccion = new Direccion() ;
        $direccion->fill($request->all()) ;
        $direccion->save() ;
        $almacen = new Almacen() ;
        $almacen->denominacion = $request->denominacion ;
        $almacen->direccion_id = $direccion->id ;
        $almacen->save() ;
        return redirect()->back()->with('confirmar', 'bien') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function show(Almacen $almacen)
    {
        return view('almacenes.show' , compact('almacen')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function edit(Almacen $almacen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $almacen = Almacen::find($id) ;
        $direccion = $almacen->direccion ;
        $direccion->fill($request->all()) ;
        $direccion->update();
        $almacen->denominacion = $request->denominacion ;
        $almacen->update() ;
        return redirect()->back()->with('confirmar' , 'bien');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $almacen = Almacen::find($id) ;
        try{
            $almacen->delete() ;
            return redirect()->back()->with('borrado' , 'ok') ;

        }catch(Exception $e){
            alert()->error('No es posible eliminar el Almacen' , 'Error') ;
            return redirect('/almacenes') ;
        }
    }
}
