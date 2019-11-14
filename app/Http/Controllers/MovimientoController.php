<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\CabeceraMovimiento;
use App\Existencia;
use App\HistorialEstado;
use App\Movimiento;
use App\Producto;
use App\Proveedor;
use App\Rubro;
use App\TipoComprobante;
use App\TipoMovimiento;
use App\Trabajo;
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
        $movimientos = Movimiento::all();
        $tipoMovimientos = TipoMovimiento::all();
        $productos = Producto::all();
        return view('movimientos.index', compact('movimientos', 'tipoMovimientos', 'productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createIngreso()
    {
        $almacenes = Almacen::all();
        $proveedores = Proveedor::all();
        // $tiposMovimientos = TipoMovimiento::all() ;
        $productos = Producto::all();
        $tiposComprobantes = TipoComprobante::all();
        $movimiento = new Movimiento();
        $cabeceraMov = new CabeceraMovimiento();
        $tipoMovimientos = TipoMovimiento::all();
        foreach ($tipoMovimientos as $tm) {
            if (($tm->operacion != true)) {
                $tipoMovimientos->pull($tm->id - 1);
            }
        }
        return view('movimientos.createIngreso', compact('movimiento', 'cabeceraMov', 'almacenes', 'proveedores', 'productos', 'tiposComprobantes', 'tipoMovimientos'));
    }

    public function createTransferencia()
    {
        $almacenes = Almacen::all();
        $productos = Producto::all();
        $tiposComprobantes = TipoComprobante::all();
        $tipoMovimientos = DB::table('tipo_movimientos')->where('operacion', null)->get();
        return view('movimientos.createTransferencia', compact('almacenes', 'productos', 'tipoMovimientos', 'tiposComprobantes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIngreso(Request $request, CabeceraMovimiento $cabeceraMov)
    {
        if ($request->cantidad == null) {
            alert()->error('Debe cargar la tabla', 'Error');
            return redirect()->back();
        }
        DB::beginTransaction();
        try {
            $cabeceraMov->fill($request->only(['fecha', 'fechaComprobante', 'proveedor_id', 'numeroComprobante', 'tipoComprobante_id']));
            $cabeceraMov->save();
            for ($i = 0; $i < sizeof($request->cantidad); $i++) {
                $valorPrecio = $request->precio[$i] ;
                $valorPrecio = str_replace(".", "", $valorPrecio);
                $valorPrecio = str_replace(",", ".", $valorPrecio);
                $movimiento = new Movimiento();
                $movimiento->cabecera_movimiento_id = $cabeceraMov->id;
                $movimiento->cantidad = $request->cantidad[$i];
                $movimiento->precio = $valorPrecio;
                $movimiento->producto_id = $request->producto_id[$i];
                $movimiento->tipo_movimiento_id = $request->tipoMovimiento_id;
                $movimiento->almacenOrigen_id = $request->almacenOrigen_id;
                $movimiento->almacenDestino_id = $request->almacenDestino_id;
                $movimiento->save();
                $almacen = Almacen::find($request->almacenDestino_id);
                if ($almacen->existeProducto($request->producto_id[$i])) {
                    $exis = $almacen->existencias;
                    foreach ($exis as $e) {
                        if ($e->producto->id == $request->producto_id[$i]) {
                            $e->cantidad += $request->cantidad[$i];
                            $e->update();
                        }
                    }
                } else {
                    $existencia = new Existencia();
                    $existencia->almacen_id =  $request->almacenDestino_id;
                    $existencia->producto_id = $request->producto_id[$i];
                    $existencia->cantidad = $request->cantidad[$i];
                    $existencia->save();
                }
            }
            //asociar productos a proveedores
            $proveedor = Proveedor::find($request->proveedor_id);
            $proveedor->productos()->attach($request->input('producto_id', []));

            //comprobar trabajos en estado falta de productos y cambiarlos de ser necesario
            $recuperacion = Trabajo::all()->where('estado_id', 7);
            $trabajos = collect() ;
            foreach($recuperacion as $recu){
                $trabajos->add($recu) ;
            }
            // return $trabajos;
            //traigo los trabajos que estan en espera , iniciados
            $trabEspera = Trabajo::all()->where('estado_id', '<>', 5)->where('estado_id', '<>', 4)->where('estado_id', '<>', 1)->where('estado_id', '<>', 7);


            //calculo del stock logico para saber si cambiar de estado a los trabajos pendientes
            $stockFantasma = collect();
            $productosRecomendados = collect();

            //burbuja para ordenar los de mayor prioridad
            for ($i = 1; $i < count($trabajos); $i++) {
                for ($j = 0; $j < count($trabajos) - $i; $j++) {
                    if ($trabajos[$j]->reclamo->tipoReclamo->prioridad->nivel < $trabajos[$j + 1]->reclamo->tipoReclamo->prioridad->nivel) {
                        $k = $trabajos[$j + 1];
                        $trabajos[$j + 1] = $trabajos[$j];
                        $trabajos[$j] = $k;
                    }
                }
            }

            //burbuja para los de mayor tiempo segun prioridad de cada uno, si tienen igual prioridad se compara el tiempo de duracion
            for ($i = 1; $i < count($trabajos); $i++) {
                for ($j = 0; $j < count($trabajos) - $i; $j++) {
                    if (($trabajos[$j]->reclamo->tipoReclamo->prioridad == $trabajos[$j + 1]->reclamo->tipoReclamo->prioridad) && ($trabajos[$j]->duracionEstimadaReal($trabajos[$j]->reclamo->tipoReclamo->id) < $trabajos[$j + 1]->duracionEstimadaReal($trabajos[$j + 1]->reclamo->tipoReclamo->id))) {
                        $k = $trabajos[$j + 1];
                        $trabajos[$j + 1] = $trabajos[$j];
                        $trabajos[$j] = $k;
                    }
                }
            }


            foreach ($trabEspera as $trabajito) {
                foreach ($trabajito->recomendaciones() as $prodRecomendado) {
                    $prodRecomendado->cantidadMinima = 0;
                    $prodRecomendado->cantidadMinima += $trabajito->recomendacionCantidad($prodRecomendado);
                    $productosRecomendados->add($prodRecomendado);
                }
            }
            foreach ($trabajos as $trabajo) {
                $hayStock = true;
                if (!$trabajo->recomendaciones()->isEmpty()) {
                    foreach ($trabajo->recomendaciones() as $productoRecomendado) {

                        $cantidadAcumulada = 0;
                        foreach ($productosRecomendados as $r) {
                            if ($r->id == $productoRecomendado->id) {
                                $cantidadAcumulada += $r->cantidadMinima;
                            }
                        }


                        if (!$stockFantasma->isEmpty()) {
                            $cantProduct = 0;
                            foreach ($stockFantasma as $produc) {
                                if ($produc->id == $productoRecomendado->id) {
                                    $cantProduct += $produc->cantidadMinima;
                                }
                            }
                            $cantidadAcumulada += $cantProduct;
                            if ($trabajo->recomendacionCantidad($productoRecomendado) <= $productoRecomendado->cantidadTotal()) {
                                if ($trabajo->recomendacionCantidad($productoRecomendado) > ($productoRecomendado->cantidadTotal() - $cantidadAcumulada)) {
                                    $hayStock = false;
                                }
                            } else {
                                $hayStock = false;
                            }
                        } else {
                            if ($trabajo->recomendacionCantidad($productoRecomendado) <= $productoRecomendado->cantidadTotal()) {
                                // dd($trabajo->recomendacionCantidad($productoRecomendado) <= $productoRecomendado->cantidadTotal());
                                if ($trabajo->recomendacionCantidad($productoRecomendado) > ($productoRecomendado->cantidadTotal() - $cantidadAcumulada)) {
                                    $hayStock = false;
                                }
                            } else {
                                $hayStock = false;
                            }
                        }
                    }
                    if ($hayStock) {
                        $trabajo->estado_id = $trabajo->reclamo->tipoReclamo->flujoTrabajo->siguienteEstado($trabajo->estado)->id;
                        $trabajo->update();
                        $hisFaltante = new HistorialEstado();
                        $hisFaltante->reclamo_id = $trabajo->reclamo->id;
                        $hisFaltante->estado_id = $trabajo->estado_id;
                        $hisFaltante->save();
                        foreach ($trabajo->recomendaciones() as $otraRecomendacion) {
                            $otraRecomendacion->cantidadMinima = 0;
                            $otraRecomendacion->cantidadMinima += $trabajo->recomendacionCantidad($otraRecomendacion);
                            $stockFantasma->add($otraRecomendacion);
                        }
                    }
                }
            }

            DB::commit();
            return redirect('/movimientos')->with('confirmar', 'asdf');
        } catch (Exception $e) {
            DB::rollback();
            return $e ;
            alert()->error($e->getMessage())->persistent('ok');
            return redirect()->back();
        }
    }


    public function storeTransferencia(Request $request)
    {
        if ($request->cantidad == null) {
            alert()->error('Debe cargar la tabla', 'Error');
            return redirect()->back();
        }
        DB::beginTransaction();
        $cabMov = new CabeceraMovimiento();
        $cabMov->fill($request->only('fecha', 'fechaComprobante', 'numeroComprobante', 'tipoComprobante_id'));
        $cabMov->save();
        for ($i = 0; $i < sizeof($request->cantidad); $i++) {
            $movimiento = new Movimiento();
            $movimiento->cabecera_movimiento_id = $cabMov->id;
            $movimiento->cantidad = $request->cantidad[$i];
            $movimiento->producto_id = $request->producto_id[$i];
            $movimiento->tipo_movimiento_id = $request->tipoMovimiento_id;
            $movimiento->almacenOrigen_id = $request->almacenOrigen_id;
            $movimiento->almacenDestino_id = $request->almacenDestino_id;
            $movimiento->save();
            $almacenOrigen = Almacen::find($request->almacenOrigen_id);
            $almacenDestino = Almacen::find($request->almacenDestino_id);
            if ($almacenOrigen->existeProducto($request->producto_id[$i])) {
                if ($request->cantidad[$i] <= $almacenOrigen->getCantidadProd($request->producto_id[$i])) {
                    if (!$almacenDestino->existeProducto($request->producto_id[$i])) {
                        $exisNueva = new Existencia();
                        $exisNueva->setAlmacen($almacenDestino->id);
                        $exisNueva->setProducto($request->producto_id[$i]);
                        $exisNueva->setCantidad($request->cantidad[$i]);
                        $exisNueva->save();
                    }

                    $exis1 = $almacenOrigen->existencias;
                    foreach ($exis1 as $e1) {
                        if ($e1->producto->id == $request->producto_id[$i]) {
                            $e1->cantidad -= $request->cantidad[$i];
                            $e1->update();
                        }
                    }
                    $exis2 = $almacenDestino->existencias;
                    foreach ($exis2 as $e2) {
                        if ($e2->producto->id == $request->producto_id[$i]) {
                            $e2->cantidad += $request->cantidad[$i];
                            $e2->update();
                        }
                    }
                } else {
                    alert()->error('La cantidad de ' . $request->cantidad[$i] . ' de ' . Producto::find($request->producto_id[$i])->nombre . ' excede a la existente!', 'Error')->persistent('Cerrar');
                    DB::rollBack();
                    return redirect()->back();
                }
            } else {
                alert()->error('No existe el producto ' . Producto::find($request->producto_id[$i])->nombre . ' en el almacen de origen ' . $almacenOrigen->denominacion, 'Error')->persistent('Cerrar');
                DB::rollBack();
                return redirect()->back();
            }
        }
        DB::commit();
        return redirect('/movimientos')->with('confirmar', 'asdf');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Movimiento  $movimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Movimiento $movimiento)
    {
        return view('movimientos.show', compact('movimiento'));
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
        try {
            if ($movimiento->tipoMovimiento->operacion == true) {
                foreach ($movimiento->almacenDestino->existencias as $exi) {
                    if ($exi->producto->id == $movimiento->producto->id) {
                        $exi->cantidad -= $movimiento->cantidad;
                        $exi->update();
                        $movimiento->delete();
                        return redirect()->back()->with('borrado', 'ok');
                    }
                }
            } elseif ($movimiento->tipoMovimiento->operacion === null) {
                foreach ($movimiento->almacenDestino->existencias as $exi) {
                    if ($exi->producto->id == $movimiento->producto->id) {
                        $exi->cantidad -= $movimiento->cantidad;
                        $exi->update();

                    }
                }
                foreach ($movimiento->almacenOrigen->existencias as $exi) {
                    if ($exi->producto->id == $movimiento->producto->id) {
                        $exi->cantidad += $movimiento->cantidad;
                        $exi->update();
                    }
                }
                $movimiento->delete();
            } else {
                alert()->error('No es posible eliminar el movimiento EGRESO debido a que se produjo por un trabajo', 'Error');
                return redirect()->back() ;
            }
        } catch (Exception $e) {
            alert()->error('No es posible eliminar el Movimiento', 'Error');
            return redirect('/movimientos');
        }
    }

    public function validar()
    {
        return request()->validate([
            'producto_id.*' => 'required',
            'cantidad.*' => 'required|numeric|min:0|not_in:0',
        ]);
    }

    public function filtro(Request $request)
    {

        // $d1 = Carbon::now() ;
        // $d2 = Carbon::now() ;
        // return var_dump($d1->notEqualTo($d2)) ;

        $movimientos = Movimiento::all();


        foreach ($movimientos as $id => $mov) {
            $f = Carbon::create($mov->cabeceraMovimiento->fecha);
            $fecha1 = Carbon::create($request->input('fecha1'));
            $fecha2 = Carbon::create($request->input('fecha2'));

            if (($f->lessThan($fecha1)) || ($f->greaterThan($fecha2))) {
                $movimientos->pull($id);
            }
        }
    }
}
