<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\CabeceraMovimiento;
use App\Movimiento;
use App\Producto;
use App\Proveedor;
use App\TipoMovimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $almacenes = Almacen::all() ;
        $proveedores = Proveedor::all() ;
        // $tiposMovimientos = TipoMovimiento::all() ;
        $productos = Producto::all() ;
        $movimiento = new Movimiento() ;
        $cabeceraMov = new CabeceraMovimiento() ;
        return view('movimientos.index', compact('movimiento','cabeceraMov','almacenes' , 'proveedores' , 'productos')) ;
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
    public function store(Request $request, Movimiento $movimiento, CabeceraMovimiento $cabeceraMov)
    {
        // $cabeceraMov->fill($request->only(['fecha' , 'almacen_id' , 'proveedor_id'])) ;
        // $cabeceraMov->save();
        // $movimiento->cabecera_movimiento_id = $cabeceraMov->id ;
        // $movimiento->fill($request->only(['cantidad' ,'producto_id' , 'tipo_movimiento_id'])) ;
        // $prod = Producto::find($request->input('producto_id')) ;
        // if($request->input('tipo_movimiento_id') == 1){
        //     $prod->sumarCantidad($request->cantidad) ;
        //     $prod->update() ;
        // }else{
        //     $prod->restarCantidad($request->cantidad) ;
        //     $prod->update() ;
        // }
        // $movimiento->save() ;
        // return redirect('/productos') ;

    }

    public function ingreso(Request $request, Movimiento $movimiento, CabeceraMovimiento $cabeceraMov)
    {
        $this->validar();
        $cabeceraMov->fill($request->only(['fecha' , 'almacen_id' , 'proveedor_id'])) ;
        $cabeceraMov->save();
        $movimiento->cabecera_movimiento_id = $cabeceraMov->id ;
        $movimiento->tipo_movimiento_id = 1 ;
        $movimiento->fill($request->only(['cantidad' ,'producto_id' ])) ;
        $prod = Producto::find($request->input('producto_id')) ;
        $prod->sumarCantidad($request->cantidad) ;
        $prod->update() ;
        $movimiento->save() ;
        return redirect('/productos') ;

    }

    public function egreso(Request $request, Movimiento $movimiento, CabeceraMovimiento $cabeceraMov)
    {
        $this->validar();
        $cabeceraMov->fill($request->only(['fecha' , 'almacen_id' , 'proveedor_id'])) ;
        $cabeceraMov->save();
        $movimiento->cabecera_movimiento_id = $cabeceraMov->id ;
        $movimiento->tipo_movimiento_id = 2 ;
        $movimiento->fill($request->only(['cantidad' ,'producto_id'])) ;
        $prod = Producto::find($request->input('producto_id')) ;
        $prod->restarCantidad($request->cantidad) ;
        $prod->update() ;
        $movimiento->save() ;
        return redirect('/productos') ;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movimiento  $movimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Movimiento $movimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movimiento  $movimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Movimiento $movimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movimiento  $movimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movimiento $movimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movimiento  $movimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movimiento $movimiento)
    {
        //
    }

    public function validar(){
        $data = request()->validate([
            'almacen_id' => 'required' ,
            'proveedor_id' => 'required' ,
            'fecha' => 'required' ,
            'producto_id' => 'required' ,
            'cantidad' => 'required|numeric|min:0|not_in:0' ,
        ]);
    }

}
