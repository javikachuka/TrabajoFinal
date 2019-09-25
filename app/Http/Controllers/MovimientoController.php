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
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        $tipoMovimientos = TipoMovimiento::all() ;
        foreach($tipoMovimientos as $tm){
            if(($tm->operacion != true)){
                $tipoMovimientos->pull($tm->id -1) ;
            }
        }
        return view('movimientos.createIngreso', compact('movimiento','cabeceraMov','almacenes' , 'proveedores' , 'productos' , 'tiposComprobantes' , 'tipoMovimientos')) ;
    }

    public function createTransferencia(){
        $almacenes = Almacen::all() ;
        $productos = Producto::all() ;
        $tiposComprobantes = TipoComprobante::all() ;
        $tipoMovimientos = DB::table('tipo_movimientos')->where('operacion' , null)->get();
        return view('movimientos.createTransferencia' , compact('almacenes' , 'productos' , 'tipoMovimientos', 'tiposComprobantes')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIngreso(Request $request, CabeceraMovimiento $cabeceraMov)
    {
        if($request->cantidad == null){
            alert()->error('Debe cargar la tabla' , 'Error') ;
            return redirect()->back();
        }
        DB::beginTransaction();
        try{
            $cabeceraMov->fill($request->only(['fecha' , 'fechaComprobante','proveedor_id','numeroComprobante', 'tipoComprobante_id'])) ;
            $cabeceraMov->save();
            for($i = 0 ; $i < sizeof($request->cantidad); $i++){
                $movimiento = new Movimiento() ;
                $movimiento->cabecera_movimiento_id = $cabeceraMov->id ;
                $movimiento->cantidad = $request->cantidad[$i] ;
                $movimiento->precio = $request->precio[$i] ;
                $movimiento->producto_id = $request->producto_id[$i] ;
                $movimiento->tipo_movimiento_id = $request->tipoMovimiento_id ;
                $movimiento->almacenOrigen_id = $request->almacenOrigen_id ;
                $movimiento->almacenDestino_id = $request->almacenDestino_id ;
                $movimiento->save() ;
                $almacen = Almacen::find($request->almacenDestino_id) ;
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
                    $existencia->almacen_id =  $request->almacenDestino_id ;
                    $existencia->producto_id = $request->producto_id[$i] ;
                    $existencia->cantidad = $request->cantidad[$i] ;
                    $existencia->save() ;

                }
            }
            DB::commit();
            return redirect('/movimientos')->with('confirmar', 'asdf') ;
        }catch(Exception $e){
            DB::rollback();
            alert()->error($e->getMessage());
            return redirect()->back() ;
        }

    }


    public function storeTransferencia(Request $request ){
        if($request->cantidad == null){
            alert()->error('Debe cargar la tabla' , 'Error') ;
            return redirect()->back();
        }
        DB::beginTransaction() ;
        $cabMov = new CabeceraMovimiento() ;
        $cabMov->fill($request->only('fecha' , 'fechaComprobante' , 'numeroComprobante', 'tipoComprobante_id')) ;
        $cabMov->save() ;
        $error = false ;
        for($i = 0 ; $i < sizeof($request->cantidad); $i++){
            $movimiento = new Movimiento() ;
            $movimiento->cabecera_movimiento_id = $cabMov->id ;
            $movimiento->cantidad = $request->cantidad[$i] ;
            $movimiento->producto_id = $request->producto_id[$i] ;
            $movimiento->tipo_movimiento_id = $request->tipoMovimiento_id ;
            $movimiento->almacenOrigen_id = $request->almacenOrigen_id ;
            $movimiento->almacenDestino_id = $request->almacenDestino_id ;
            $movimiento->save() ;
            $almacenOrigen = Almacen::find($request->almacenOrigen_id) ;
            $almacenDestino = Almacen::find($request->almacenDestino_id) ;
            if($almacenOrigen->existeProducto($request->producto_id[$i])){
                if( $request->cantidad[$i] <= $almacenOrigen->getCantidadProd($request->producto_id[$i])){
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
                    alert()->error('La cantidad de '.$request->cantidad[$i] .' de '. Producto::find($request->producto_id[$i])->nombre . ' excede a la existente!' , 'Error')->persistent('cerrar') ;
                    DB::rollBack();
                    return redirect()->back();
                }

            }else{
                alert()->error('No existe el producto '. Producto::find($request->producto_id[$i])->nombre . ' en el almacen de origen '. $almacenOrigen->denominacion , 'Error')->persistent('cerrar') ;
                DB::rollBack();
                return redirect()->back()->with('cancelar' , 'asdf') ;
            }
        }
        DB::commit() ;
        return redirect('/movimientos')->with('confirmar' , 'asdf') ;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Movimiento  $movimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Movimiento $movimiento)
    {
        return view('movimientos.show' , compact('movimiento')) ;
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
        try{
            if($movimiento->tipoMovimiento->operacion == true){
                foreach($movimiento->almacenDestino->existencias as $exi){
                    if($exi->producto->id == $movimiento->producto->id){
                        $exi->cantidad -= $movimiento->cantidad ;
                        $exi->update() ;
                        $movimiento->delete();
                        return redirect()->back()->with('borrado' , 'ok') ;
                    }
                }
            }elseif($movimiento->tipoMovimiento->operacion == false){
                foreach($movimiento->almacenDestino->existencias as $exi){
                    if($exi->producto->id == $movimiento->producto->id){
                        $exi->cantidad -= $movimiento->cantidad ;
                        $exi->update() ;
                        $movimiento->delete();
                        return redirect()->back()->with('borrado' , 'ok') ;
                    }
                }
                foreach($movimiento->almacenOrigen->existencias as $exi){
                    if($exi->producto->id == $movimiento->producto->id){
                        $exi->cantidad += $movimiento->cantidad ;
                        $exi->update() ;
                        $movimiento->delete();
                        return redirect()->back()->with('borrado' , 'ok') ;
                    }
                }

            }
        }catch(Exception $e){
            alert()->error('No es posible eliminar el Movimiento' , 'Error') ;
            return redirect('/movimientos') ;
        }
    }

    public function validar(){
        return request()->validate([
            'producto_id.*' => 'required' ,
            'cantidad.*' => 'required|numeric|min:0|not_in:0' ,
        ]);
    }

    public function filtro(Request $request){

        // $d1 = Carbon::now() ;
        // $d2 = Carbon::now() ;
        // return var_dump($d1->notEqualTo($d2)) ;

        $movimientos = Movimiento::all();


        foreach($movimientos as $id => $mov){
            $f = Carbon::create($mov->cabeceraMovimiento->fecha) ;
            $fecha1 = Carbon::create($request->input('fecha1')) ;
            $fecha2 = Carbon::create($request->input('fecha2')) ;

            if (($f->lessThan($fecha1)) || ($f->greaterThan($fecha2))){
                $movimientos->pull($id) ;
            }

        }



    }

}
