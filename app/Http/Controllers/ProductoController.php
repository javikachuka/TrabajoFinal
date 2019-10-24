<?php

namespace App\Http\Controllers;

use App\Existencia;
use App\Medida;
use App\Producto;
use App\Rubro;
use Exception;
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
        return redirect('/productos')->with('confirmar', 'ok') ;
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
        request()->validate([
            'nombre' => 'required|unique:productos,nombre,' . $producto->id,
            'codigo' => 'required|numeric|unique:productos,codigo,' . $producto->id,
            'cantidadMinima' => 'required|numeric' ,
            'rubro_id' => 'required',
        ]);
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

        try{
            if($producto->movimientos->isEmpty()){
                if($producto->proveedores->isEmpty()){
                    if($producto->detalles->isEmpty()){
                        $producto->delete() ;
                        return redirect()->back()->with('borrado' , 'guardado') ;
                    }
                }
            }
            alert()->error('No es posible eliminar el producto debido a que esta siendo utilizado!', 'Error')->persistent() ;
            return redirect()->back() ;
        }catch(Exception $e){
            alert()->error('No es posible eliminar' , 'Error!') ;
            return redirect('/productos') ;
        }


    }

    public function validar(){
        $data = request()->validate([
            'nombre' => 'required|unique:productos,nombre' ,
            'codigo' => 'required|numeric|unique:productos,codigo' ,
            'cantidadMinima' => 'required|numeric' ,
            'rubro_id' => 'required',
        ]);
    }
}
