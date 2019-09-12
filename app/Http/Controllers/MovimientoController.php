<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\CabeceraMovimiento;
use App\Existencia;
use App\Movimiento;
use App\Producto;
use App\Proveedor;
use App\TipoComprobante;
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
        $movimientos = Movimiento::all() ;
        return view('movimientos.index', compact('movimientos')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createIngreso()
    {
        $almacenes = Almacen::all() ;
        $proveedores = Proveedor::all() ;
        // $tiposMovimientos = TipoMovimiento::all() ;
        $productos = Producto::all() ;
        $tiposComprobantes = TipoComprobante::all() ;
        $movimiento = new Movimiento() ;
        $cabeceraMov = new CabeceraMovimiento() ;
        return view('movimientos.createIngreso', compact('movimiento','cabeceraMov','almacenes' , 'proveedores' , 'productos' , 'tiposComprobantes')) ;
    }

    public function createTransferencia(){
        $almacenes = Almacen::all() ;
        $productos = Producto::all() ;

        return view('movimientos.createTransferencia' , compact('almacenes' , 'productos')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIngreso(Request $request, CabeceraMovimiento $cabeceraMov)
    {

        $cabeceraMov->fill($request->only(['fecha' , 'fechaComprobante','proveedor_id','numeroComprobante', 'tipoComprobante_id'])) ;
        $cabeceraMov->save();
        for($i = 0 ; $i < sizeof($request->cantidad); $i++){
            $movimiento = new Movimiento() ;
            $movimiento->cabecera_movimiento_id = $cabeceraMov->id ;
            $movimiento->cantidad = $request->cantidad[$i] ;
            $movimiento->precio = $request->precio[$i] ;
            $movimiento->producto_id = $request->producto_id[$i] ;
            $movimiento->tipo_movimiento_id = 1 ;
            $movimiento->almacenOrigen_id = $request->almacenOrigen_id[$i] ;
            $movimiento->almacenDestino_id = $request->almacenDestino_id[$i] ;
            $movimiento->save() ;
            $almacen = Almacen::find($request->almacenDestino_id[$i]) ;
            if($almacen->existeProducto($request->producto_id[$i])){
                $exis = $almacen->existencias ;
                foreach($exis as $e){
                    if($e->producto->id == $request->producto_id[$i]){
                        $e->cantidad += $request->cantidad[$i] ;
                        $e->update() ;
                    }
                }
            }else
            {
                $existencia = new Existencia() ;
                $existencia->almacen_id =  $request->almacenDestino_id[$i] ;
                $existencia->producto_id = $request->producto_id[$i] ;
                $existencia->cantidad = $request->cantidad[$i] ;
                $existencia->save() ;
            }
        }
        return redirect('/productos') ;

    }


    public function storeTransferencia(Request $request ){
        $cabMov = new CabeceraMovimiento() ;
        $cabMov->fill($request->only('fecha')) ;
        $cabMov->save() ;
        $msg = null ;
        for($i = 0 ; $i < sizeof($request->cantidad); $i++){
            $movimiento = new Movimiento() ;
            $movimiento->cabecera_movimiento_id = $cabMov->id ;
            $movimiento->cantidad = $request->cantidad[$i] ;
            $movimiento->producto_id = $request->producto_id[$i] ;
            $movimiento->tipo_movimiento_id = 3 ;
            $movimiento->almacenOrigen_id = $request->almacenOrigen_id[$i] ;
            $movimiento->almacenDestino_id = $request->almacenDestino_id[$i] ;
            $movimiento->save() ;
            $almacenOrigen = Almacen::find($request->almacenOrigen_id[$i]) ;
            $almacenDestino = Almacen::find($request->almacenDestino_id[$i]) ;
            if($almacenOrigen->existeProducto($request->producto_id[$i])){
                if( $request->cantidad[$i] <= $almacenOrigen->getCantidadProd($request->cantidad[$i])){
                    if(!$almacenDestino->existeProducto($request->producto_id[$i])){
                        $exisNueva = new Existencia() ;
                        $exisNueva->setAlmacen($almacenDestino->id) ;
                        $exisNueva->setProducto($request->producto_id[$i]) ;
                        $exisNueva->setCantidad($request->cantidad[$i]);
                        $exisNueva->save() ;
                    }
                    $exis1 = $almacenOrigen->existencias ;
                    foreach($exis1 as $e1){
                        if($e1->producto->id == $request->producto_id[$i]){
                            $e1->cantidad -= $request->cantidad[$i] ;
                            $e1->update() ;
                        }
                    }
                    $exis2 = $almacenDestino->existencias ;
                    foreach($exis2 as $e2){
                        if($e2->producto->id == $request->producto_id[$i]){
                            $e2->cantidad += $request->cantidad[$i] ;
                            $e2->update() ;
                        }
                    }
            }else{
                $msg = 'Cantidad insuficiente! Linea ' ;
            }

            }
        }
        if($msg == null){
            return redirect('/productos')->with('confirmar' , 'sdfa') ;
        }else{
            return redirect()->back()->with('msg') ;
        }
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
