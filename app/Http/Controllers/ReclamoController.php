<?php

namespace App\Http\Controllers;

use App\Control;
use App\Detalle;
use App\HistorialEstado;
use App\Pedido;
use App\Reclamo;
use App\Requisito;
use Illuminate\Http\Request;
use App\TipoReclamo;
use App\Socio;
use App\Trabajo;
use App\Turno;
use App\Zona;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ReclamoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reclamos = Reclamo::all();
        $tipoReclamos = TipoReclamo::all();
        $socios = Socio::all();
        $estados = collect();
        if (!$reclamos->isEmpty()) {
            $estados = $reclamos[0]->tipoReclamo->flujoTrabajo->getEstados();
        }
        return view('reclamos.index', compact('reclamos', 'tipoReclamos', 'socios', 'estados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reclamo = new Reclamo();
        $socios = Socio::all();
        $zonas = Zona::all();
        $tipos_reclamos = TipoReclamo::all();
        $reclamos = Reclamo::all();
        return view('reclamos.create', compact('reclamo', 'reclamos', 'socios', 'tipos_reclamos', 'zonas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Reclamo $reclamo)
    {
        // if($reclamo->tipoReclamo->flujoTrabajo_id == null){
        //     alert()->info('Por favor vaya a "Gestion de Reclamos > Tipo de Reclamos" y configure los tipos de reclamos a un flujo de trabajo.' , 'Atencion')->persistent();
        // }

        DB::beginTransaction();
        try {
            $socio = Socio::find($request->socio_id);
            // return sizeof($request->requisitos) ;
            $reclamo->fill($request->only(['tipoReclamo_id', 'fecha', 'detalle']));
            $reclamo->direccion_id = $socio->getIdDireccion($request->nro_conexion);
            $reclamo->user_id = auth()->user()->id;
            $reclamo->save();
            if ($reclamo->tipoReclamo->trabajo == true) { // hay un atributo que es boolean (trabajo) y me dice si el reclamo conlleva o no un trabajo

                //generacion de un nuevo trabajo correspondiente al reclamo
                $trabajo = new Trabajo();
                $trabajo->fecha = $reclamo->fecha;
                $trabajo->estado_id = $reclamo->tipoReclamo->flujoTrabajo->getEstadoInicial();
                $trabajo->save();

                //asociacion de trabajo con reclamo
                $reclamo->trabajo_id = $trabajo->id;
                $reclamo->update();


                //historial de estados del reclamo
                $historial = new HistorialEstado();
                $historial->reclamo_id = $reclamo->id;
                $historial->estado_id = $trabajo->estado_id;
                $historial->save();

                //corresponde a si el reclamo presento o no requisitos
                $posiblesEstados = $reclamo->tipoReclamo->flujoTrabajo->getPosiblesEstados($trabajo->estado); //aqui deberia ir la logica para pasar a un estado faltante
                if (($request->requisitos != null)) {
                    for ($i = 0; $i < sizeof($request->requisitos); $i++) {
                        $control = new Control();
                        $control->reclamo_id = $reclamo->id;
                        $control->requisito_id = $request->requisitos[$i];
                        $control->recibido = true;
                        $control->fecha = Carbon::now();
                        $control->save();
                    }
                    if (sizeof($request->requisitos) != sizeof($reclamo->tipoReclamo->requisitos)) {
                        foreach ($posiblesEstados as $e) {
                            if (strpos($e->nombre, 'F') !== false) {
                                $trabajo->estado_id = $e->id;
                            }
                        }
                    } else {
                        //traemos todos los trabajos en un estado que no sea terminado , en falta de doc o recibido.
                        //serian los trabajos que estan en espera, iniciados o sin existencias
                        $trabajos = Trabajo::all()->where('estado_id', '<>', 5)->where('estado_id', '<>', 4)->where('estado_id', '<>', 1);
                        $hayStock = true;

                        if (!$trabajo->recomendaciones()->isEmpty()) {
                            foreach ($trabajo->recomendaciones() as $productoRecomendado) {
                                if ($trabajo->recomendacionCantidad($productoRecomendado) <= $productoRecomendado->cantidadTotal()) {
                                    $cantidadAcumulada = 0;
                                    foreach ($trabajos as $t) {
                                        foreach ($t->recomendaciones() as $r) {
                                            if ($r->id == $productoRecomendado->id) {
                                                $cantidadAcumulada += $t->recomendacionCantidad($r);
                                            }
                                        }
                                    }
                                    if ($trabajo->recomendacionCantidad($productoRecomendado) > ($productoRecomendado->cantidadTotal() - $cantidadAcumulada)) {
                                        $hayStock = false;
                                    }
                                    $cantidadAcumulada += $trabajo->recomendacionCantidad($productoRecomendado);
                                    if ($productoRecomendado->isCantidadMinima($cantidadAcumulada)) {
                                        $pedido = Pedido::where('generado', false)->get();
                                        if ($pedido->isEmpty()) {
                                            $pedido = new Pedido();
                                            $pedido->fecha = Carbon::now();
                                            $pedido->save();
                                            if (!$pedido->detalles->contains('producto_id', $productoRecomendado->id)) {
                                                $detalle = new Detalle();
                                                $detalle->pedido_id = $pedido->siguienteId();
                                                $detalle->producto_id = $productoRecomendado->id;
                                                $detalle->cantidad = $productoRecomendado->cantidadMinima * 2;
                                                $detalle->save();
                                            }
                                        } else {
                                            if (!$pedido->first()->detalles->contains('producto_id', $productoRecomendado->id)) {
                                                $detalle = new Detalle();
                                                $detalle->pedido_id = $pedido->first()->id;
                                                $detalle->producto_id = $productoRecomendado->id;
                                                $detalle->cantidad = $productoRecomendado->cantidadMinima * 2;
                                                $detalle->save();
                                            }
                                        }
                                    }
                                } else {
                                    $hayStock = false;
                                    if ($productoRecomendado->estaEnCantidadMinima()) {
                                        $pedido = Pedido::where('generado', false)->get();
                                        if ($pedido->isEmpty()) {
                                            $pedido = new Pedido();
                                            $pedido->fecha = Carbon::now();
                                            $pedido->save();
                                            if (!$pedido->detalles->contains('producto_id', $productoRecomendado->id)) {
                                                $detalle = new Detalle();
                                                $detalle->pedido_id = $pedido->siguienteId();
                                                $detalle->producto_id = $productoRecomendado->id;
                                                $detalle->cantidad = $productoRecomendado->cantidadMinima * 2;
                                                $detalle->save();
                                            }
                                        } else {
                                            if (!$pedido->first()->detalles->contains('producto_id', $productoRecomendado->id)) {
                                                $detalle = new Detalle();
                                                $detalle->pedido_id = $pedido->first()->id;
                                                $detalle->producto_id = $productoRecomendado->id;
                                                $detalle->cantidad = $productoRecomendado->cantidadMinima * 2;
                                                $detalle->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if ($hayStock) {
                            foreach ($posiblesEstados as $e) {
                                if ($e->nombre == 'EN ESPERA') {
                                    $trabajo->estado_id = $e->id;
                                }
                            }
                            if($trabajo->reclamo->tipoReclamo->prioridad->nivel == 5){
                                $trabajo->enviarEmail() ;
                            }
                        } else {
                            foreach ($posiblesEstados as $e) {
                                if ($e->nombre == 'SIN EXISTENCIAS') {
                                    $trabajo->estado_id = $e->id;
                                }
                            }
                        }
                    }
                    $trabajo->update();
                    $hisFaltante = new HistorialEstado();
                    $hisFaltante->reclamo_id = $reclamo->id;
                    $hisFaltante->estado_id = $trabajo->estado_id;
                    $hisFaltante->save();
                } else {
                    if ($reclamo->tipoReclamo->tieneRequisitos()) {
                        foreach ($posiblesEstados as $e) {
                            if (strpos($e->nombre, 'F') !== false) {
                                $trabajo->estado_id = $e->id;
                            }
                        }
                        //segunda comparacion para ver los reclamos que no tienen requisitos y si hay stock
                    } else {
                        //traemos todos los trabajos en un estado que no sea terminado , en falta de doc o recibido.
                        //serian los trabajos que estan en espera, iniciados o sin existencias
                        $trabajos = Trabajo::all()->where('estado_id', '<>', 5)->where('estado_id', '<>', 4)->where('estado_id', '<>', 1);
                        $hayStock = true;
                        if (!$trabajo->recomendaciones()->isEmpty()) {
                            // return $trabajo->recomendaciones();
                            foreach ($trabajo->recomendaciones() as $productoRecomendado) {
                                if ($trabajo->recomendacionCantidad($productoRecomendado) <= $productoRecomendado->cantidadTotal()) {
                                    $cantidadAcumulada = 0;
                                    foreach ($trabajos as $t) {
                                        foreach ($t->recomendaciones() as $r) {
                                            if ($r->id == $productoRecomendado->id) {
                                                $cantidadAcumulada += $t->recomendacionCantidad($r);
                                            }
                                        }
                                    }
                                    if ($trabajo->recomendacionCantidad($productoRecomendado) > ($productoRecomendado->cantidadTotal() - $cantidadAcumulada)) {
                                        $hayStock = false;
                                    }
                                    $cantidadAcumulada += $trabajo->recomendacionCantidad($productoRecomendado);

                                    if ($productoRecomendado->isCantidadMinima($cantidadAcumulada)) {
                                        $pedido = Pedido::where('generado', false)->get();
                                        if ($pedido->isEmpty()) {
                                            $pedido = new Pedido();
                                            $pedido->fecha = Carbon::now();
                                            $pedido->save();
                                            if (!$pedido->detalles->contains('producto_id', $productoRecomendado->id)) {
                                                $detalle = new Detalle();
                                                $detalle->pedido_id = $pedido->siguienteId();
                                                $detalle->producto_id = $productoRecomendado->id;
                                                $detalle->cantidad = $productoRecomendado->cantidadMinima * 2;
                                                $detalle->save();
                                            }
                                        } else {
                                            if (!$pedido->first()->detalles->contains('producto_id', $productoRecomendado->id)) {
                                                $detalle = new Detalle();
                                                $detalle->pedido_id = $pedido->first()->id;
                                                $detalle->producto_id = $productoRecomendado->id;
                                                $detalle->cantidad = $productoRecomendado->cantidadMinima * 2;
                                                $detalle->save();
                                            }
                                        }
                                    }
                                } else {
                                    $hayStock = false;
                                    if ($productoRecomendado->estaEnCantidadMinima()) {
                                        $pedido = Pedido::where('generado', false)->get();
                                        if ($pedido->isEmpty()) {
                                            $pedido = new Pedido();
                                            $pedido->fecha = Carbon::now();
                                            $pedido->save();
                                            if (!$pedido->detalles->contains('producto_id', $productoRecomendado->id)) {
                                                $detalle = new Detalle();
                                                $detalle->pedido_id = $pedido->siguienteId();
                                                $detalle->producto_id = $productoRecomendado->id;
                                                $detalle->cantidad = $productoRecomendado->cantidadMinima * 2;
                                                $detalle->save();
                                            }
                                        } else {
                                            if (!$pedido->first()->detalles->contains('producto_id', $productoRecomendado->id)) {
                                                $detalle = new Detalle();
                                                $detalle->pedido_id = $pedido->first()->id;
                                                $detalle->producto_id = $productoRecomendado->id;
                                                $detalle->cantidad = $productoRecomendado->cantidadMinima * 2;
                                                $detalle->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if ($hayStock) {
                            foreach ($posiblesEstados as $e) {
                                if ($e->nombre == 'EN ESPERA') {
                                    $trabajo->estado_id = $e->id;
                                }
                            }
                            if($trabajo->reclamo->tipoReclamo->prioridad->nivel == 5){
                                $trabajo->enviarEmail() ;
                            }
                        } else {
                            foreach ($posiblesEstados as $e) {
                                if ($e->nombre == 'SIN EXISTENCIAS') {
                                    $trabajo->estado_id = $e->id;
                                }
                            }
                        }
                    }
                    $trabajo->update();
                    $hisFaltante = new HistorialEstado();
                    $hisFaltante->reclamo_id = $reclamo->id;
                    $hisFaltante->estado_id = $trabajo->estado_id;
                    $hisFaltante->save();
                }

                //asignacion de un trabajo a un empleado
                // if($reclamo->tipoReclamo->prioridad->nivel >0 && $reclamo->tipoReclamo->prioridad->nivel <=3){

                //     $diaSemana = Carbon::create($request->fecha)->dayOfWeek ;
                //     $turnos = Turno::all() ;
                //     $turnito = null ;

                //     if(count($turnos) > 0){
                //         foreach ($turnos as $t){
                //             if($t->dia == $diaSemana ){
                //                 $turnito = $t ;
                //             }
                //         }

                //         if($turnito->users != null){
                //             foreach($turnito->users as $emple){
                //                 if($emple)
                //             }
                //             $trabajo->users()->sync($turnito->users[0]->id) ;
                //         }
                //     }

                // }

            } else {
                $historial = new HistorialEstado();
                $historial->reclamo_id = $reclamo->id;
                $historial->estado_id = $reclamo->tipoReclamo->flujoTrabajo->getEstadoInicial();
                $historial->save();

                $historial = new HistorialEstado();
                $historial->reclamo_id = $reclamo->id;
                $historial->estado_id = $reclamo->tipoReclamo->flujoTrabajo->getEstadoFinal()->id;
                $historial->save();
            }
            DB::commit();
            return redirect()->route('reclamos.index')->with('confirmar', 'asd');;
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function show(Reclamo $reclamo)
    {
        return view('reclamos.show', compact('reclamo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function edit(Reclamo $reclamo)
    {
        $socios = Socio::all();
        $tipos_reclamos = TipoReclamo::all();
        $reclamos = Reclamo::all();
        return view('reclamos.edit', compact('reclamo', 'socios', 'tipos_reclamos', 'reclamos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reclamo = Reclamo::find($id);
        $reclamo->fill($request->only(['socio_id', 'tipoReclamo_id', 'fecha', 'detalle']));
        $reclamo->update();
        if ($request->requisitos != null) {
            for ($i = 0; $i < sizeof($request->requisitos); $i++) {
                $req = Requisito::find($request->requisitos[$i]);
                if (!$reclamo->presentoRequisito($req)) {
                    $control = new Control();
                    $control->reclamo_id = $reclamo->id;
                    $control->requisito_id = $request->requisitos[$i];
                    $control->recibido = true;
                    $control->fecha = Carbon::now();
                    $control->save();
                }
            }
        }
        $posiblesEstados = $reclamo->tipoReclamo->flujoTrabajo->getPosiblesEstados($reclamo->trabajo->estado); //aqui deberia ir la logica para pasar a un estado faltante
        if (sizeof($request->requisitos) == sizeof($reclamo->tipoReclamo->requisitos)) {
            $trabajo =  $reclamo->trabajo;
            //traemos todos los trabajos en un estado que no sea terminado , en falta de doc o recibido.
            //serian los trabajos que estan en espera, iniciados o sin existencias
            $trabajos = Trabajo::all()->where('estado_id', '<>', 5)->where('estado_id', '<>', 4)->where('estado_id', '<>', 1);
            $hayStock = true;
            if (!$trabajo->recomendaciones()->isEmpty()) {
                // return $trabajo->recomendaciones();
                foreach ($trabajo->recomendaciones() as $productoRecomendado) {
                    if ($trabajo->recomendacionCantidad($productoRecomendado) <= $productoRecomendado->cantidadTotal()) {
                        $cantidadAcumulada = 0;
                        foreach ($trabajos as $t) {
                            foreach ($t->recomendaciones() as $r) {
                                if ($r->id == $productoRecomendado->id) {
                                    $cantidadAcumulada += $t->recomendacionCantidad($r);
                                }
                            }
                        }
                        if ($trabajo->recomendacionCantidad($productoRecomendado) > ($productoRecomendado->cantidadTotal() - $cantidadAcumulada)) {
                            $hayStock = false;
                        }
                    } else {
                        $hayStock = false;
                    }
                }
            }
            if ($hayStock) {
                foreach ($posiblesEstados as $e) {
                    if ($e->nombre == 'EN ESPERA') {
                        $trabajo->estado_id = $e->id;
                    }
                }
            }

            $trabajo->update();

            $historial = new HistorialEstado();
            $historial->reclamo_id = $reclamo->id;
            $historial->estado_id = $reclamo->trabajo->estado_id;
            $historial->save();
        }
        return redirect('/reclamos')->with('confirmar', 'bien');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reclamo = Reclamo::find($id);
        try {
            if ($reclamo != null) {
                if (sizeof($reclamo->historial) <= 2) {
                    $t = $reclamo->trabajo;
                    $reclamo->delete();
                    if ($t != null) {

                        $t->delete();
                    }
                    return redirect()->back()->with('borrado', 'ok');
                } else {
                    alert()->error('No es posible eliminar el reclamo debido a que ya tuvo un tratamiento!', 'Error!')->persistent('OK');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            alert()->error('No es posible eliminar', 'Error!');
            return redirect('/reclamos');
        }
    }
}
