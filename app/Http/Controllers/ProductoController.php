<?php

namespace App\Http\Controllers;

use App\Existencia;
use App\Medida;
use App\Producto;
use App\Rubro;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::all() ;

        return view('productos.index' , compact('productos')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producto = new Producto();
        $rubros = Rubro::all() ;
        $medidas = Medida::all() ;
        return view('productos.registro', compact('producto', 'rubros' , 'medidas')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Producto $producto)
    {
        $this->validar();
        $producto->fill($request->all()) ;
        $producto->save() ;
        return redirect('/productos') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        $exis = $producto->existencias ;
        return view('productos.show' , compact('producto', 'exis')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id) ;
        $rubros = Rubro::all() ;
        $medidas = Medida::all() ;
        return view('productos.edit' , compact('producto' , 'rubros' , 'medidas')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $this->validar();
        $producto->fill($request->all()) ;
        $producto->update() ;
        return redirect('/productos')->with('confirmar' , 'asdf') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        $producto->delete() ;

        return redirect()->back() ;
    }

    public function validar(){
        $data = request()->validate([
            'nombre' => 'required' ,
            'codigo' => 'required|numeric' ,
            'cantidadMinima' => 'required|numeric' ,
            'rubro_id' => 'required',
        ]);
    }
}
