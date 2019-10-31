<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Configuracion;
use App\Estado;
use App\Movimiento;
use App\Pedido;
use App\Producto;
use App\Proveedor;
use App\Reclamo;
use App\Socio;
use App\TipoMovimiento;
use App\TipoReclamo;
use App\Trabajo;
use App\User;
use Illuminate\Http\Request;
use PDF;
use DB;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Models\Audit;

class PdfController extends Controller
{

    public function proveedorPDF()
    {
        $proveedores = Proveedor::all();
        $datos = date('d/m/Y');
        $cant = sizeof($proveedores);
        $config = Configuracion::first();
        $pdf = PDF::loadView('pdf.proveedor', ['proveedores' => $proveedores, 'datos' => $datos, 'cant' => $cant, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream('proveedor.pdf');
    }

    public function movimientosPDF(Request $request)
    {

        $movimientos = Movimiento::all();
        $aux = collect();
        $filtro = "";
        if (($request->fecha1 != null && $request->fecha2 != null) && $request->producto_id == null && $request->tipoMovimiento_id == null) {
            foreach ($movimientos as $mov) {
                $f = Carbon::create($mov->cabeceraMovimiento->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if (($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) {
                    $aux->push($mov);
                }
            }
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y');
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->producto_id != null && $request->tipoMovimiento_id == null) {
            foreach ($movimientos as $mov) {
                $f = Carbon::create($mov->cabeceraMovimiento->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($mov->producto->id == $request->producto_id)) {
                    $aux->push($mov);
                }
            }
            $prod = Producto::find($request->producto_id);
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . ' y ' . $prod->nombre;
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->producto_id == null && $request->tipoMovimiento_id != null) {
            foreach ($movimientos as $mov) {
                $f = Carbon::create($mov->cabeceraMovimiento->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($mov->tipoMovimiento->id == $request->tipoMovimiento_id)) {
                    $aux->push($mov);
                }
            }
            $tipM = TipoMovimiento::find($request->tipoMovimiento_id);
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . ' e ' . $tipM->nombre;
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->producto_id != null && $request->tipoMovimiento_id != null) {
            foreach ($movimientos as $mov) {
                $f = Carbon::create($mov->cabeceraMovimiento->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($mov->tipoMovimiento->id == $request->tipoMovimiento_id) && ($mov->producto->id == $request->producto_id)) {
                    $aux->push($mov);
                }
            }
            $prod = Producto::find($request->producto_id);
            $tipM = TipoMovimiento::find($request->tipoMovimiento_id);
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . " , " . $tipM->nombre . " y " . $prod->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->producto_id != null && $request->tipoMovimiento_id != null) {
            foreach ($movimientos as $mov) {
                if (($mov->tipoMovimiento->id == $request->tipoMovimiento_id) && ($mov->producto->id == $request->producto_id)) {
                    $aux->push($mov);
                }
            }

            $prod = Producto::find($request->producto_id);
            $tipM = TipoMovimiento::find($request->tipoMovimiento_id);
            $filtro = "Filtros: " . $tipM->nombre . " y " . $prod->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->producto_id == null && $request->tipoMovimiento_id != null) {
            foreach ($movimientos as $mov) {
                if ($mov->tipoMovimiento->id == $request->tipoMovimiento_id) {
                    $aux->push($mov);
                }
            }
            $tipM = TipoMovimiento::find($request->tipoMovimiento_id);
            $filtro = "Filtros: " . $tipM->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->producto_id != null && $request->tipoMovimiento_id == null) {
            foreach ($movimientos as $mov) {
                if ($mov->producto->id == $request->producto_id) {
                    $aux->push($mov);
                }
            }

            $prod = Producto::find($request->producto_id);
            $filtro = "Filtros: " .  $prod->nombre;
        } else {
            $aux = $movimientos;
        }
        $config = Configuracion::first();
        $cant = sizeof($aux);
        $datos = date('d/m/Y');
        $pdf = PDF::loadView('pdf.movimientos', ['movimientos' => $aux, 'datos' => $datos, 'cant' => $cant, 'filtro' => $filtro, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream('movimientos.pdf');
    }

    public function trabajosPorHacerPDF()
    {
        $trabajos = Trabajo::all()->where('estado_id', 2);
        foreach ($trabajos as $key => $trabajo) {
            if (!$trabajo->users->isEmpty()) {
                if (!$trabajo->users->contains(auth()->user())) {
                    $trabajos->pull($key);
                }
            }
        }

        $aux = null;
        $max = 2200;
        $trabajosOrdenados = collect();
        foreach ($trabajos as $trabajo) {
            $trabajosOrdenados->add($trabajo);
        }

        //burbuja para ordenar los de mayor prioridad
        for ($i = 1; $i < count($trabajosOrdenados); $i++) {
            for ($j = 0; $j < count($trabajosOrdenados) - $i; $j++) {
                if ($trabajosOrdenados[$j]->reclamo->tipoReclamo->prioridad->nivel < $trabajosOrdenados[$j + 1]->reclamo->tipoReclamo->prioridad->nivel) {
                    $k = $trabajosOrdenados[$j + 1];
                    $trabajosOrdenados[$j + 1] = $trabajosOrdenados[$j];
                    $trabajosOrdenados[$j] = $k;
                }
            }
        }

        //burbuja para los de mayor tiempo segun prioridad de cada uno, si tienen igual prioridad se compara el tiempo de duracion
        for ($i = 1; $i < count($trabajosOrdenados); $i++) {
            for ($j = 0; $j < count($trabajosOrdenados) - $i; $j++) {
                if (($trabajosOrdenados[$j]->reclamo->tipoReclamo->prioridad == $trabajosOrdenados[$j + 1]->reclamo->tipoReclamo->prioridad) && ($trabajosOrdenados[$j]->duracionEstimadaReal($trabajosOrdenados[$j]->reclamo->tipoReclamo->id) < $trabajosOrdenados[$j + 1]->duracionEstimadaReal($trabajosOrdenados[$j + 1]->reclamo->tipoReclamo->id))) {
                    $k = $trabajosOrdenados[$j + 1];
                    $trabajosOrdenados[$j + 1] = $trabajosOrdenados[$j];
                    $trabajosOrdenados[$j] = $k;
                }
            }
        }
        $cant = sizeof($trabajosOrdenados);
        $config = Configuracion::first();
        $pdf = PDF::loadView('pdf.trabajosPorHacer', ['trabajos' => $trabajosOrdenados, 'cant' => $cant, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream('trabajosPorHacer.pdf');
    }

    public function reclamosPDF(Request $request)
    {

        $reclamos = Reclamo::all();
        $aux = collect();
        $filtro = "";
        if (($request->fecha1 != null && $request->fecha2 != null) && $request->tipoReclamo_id == null && $request->socio_id == null  && $request->estado_id == null) {
            foreach ($reclamos as $rec) {
                $f = Carbon::create($rec->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if (($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) {
                    $aux->push($rec);
                }
            }
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y');
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->tipoReclamo_id != null && $request->socio_id == null && $request->estado_id == null) {
            foreach ($reclamos as $rec) {
                $f = Carbon::create($rec->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($rec->tipoReclamo->id == $request->tipoReclamo_id)) {
                    $aux->push($rec);
                }
            }
            $tipRec = TipoReclamo::find($request->tipoReclamo_id);
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . ' y ' . $tipRec->nombre;
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->tipoReclamo_id == null && $request->socio_id != null  && $request->estado_id == null) {
            foreach ($reclamos as $rec) {
                $f = Carbon::create($rec->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($rec->socio->id == $request->socio_id)) {
                    $aux->push($rec);
                }
            }
            $socio = Socio::find($request->socio_id);
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . " y "  . $socio->apellido . " " . $socio->nombre;
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->tipoReclamo_id == null && $request->socio_id == null  && $request->estado_id != null) {
            foreach ($reclamos as $rec) {
                $f = Carbon::create($rec->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($rec->trabajo->estado->id == $request->estado_id)) {
                    $aux->push($rec);
                }
            }
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . " y " . $estado->nombre;
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->tipoReclamo_id != null && $request->socio_id != null  && $request->estado_id != null) {
            foreach ($reclamos as $rec) {
                $f = Carbon::create($rec->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($rec->tipoReclamo->id == $request->tipoReclamo_id) && ($rec->socio->id == $request->socio_id) && ($rec->trabajo->estado->id == $request->estado_id)) {
                    $aux->push($rec);
                }
            }
            $tipRec = TipoReclamo::find($request->tipoReclamo_id);
            $socio = Socio::find($request->socio_id);
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . " , " . $tipRec->nombre . " , " . $socio->apellido . " " . $socio->nombre  . " y " . $estado->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id != null && $request->socio_id == null  && $request->estado_id == null) {
            foreach ($reclamos as $rec) {
                if ($rec->tipoReclamo->id == $request->tipoReclamo_id) {
                    $aux->push($rec);
                }
            }

            $tipRec = TipoReclamo::find($request->tipoReclamo_id);
            $filtro = "Filtros: " . $tipRec->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id == null && $request->socio_id != null  && $request->estado_id == null) {
            foreach ($reclamos as $rec) {
                if ($rec->socio->id == $request->socio_id) {
                    $aux->push($rec);
                }
            }
            $socio = Socio::find($request->socio_id);
            $filtro = "Filtros: " . $socio->apellido . " " . $socio->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id == null && $request->socio_id == null  && $request->estado_id != null) {
            foreach ($reclamos as $rec) {
                if ($rec->trabajo->estado->id == $request->estado_id) {
                    $aux->push($rec);
                }
            }

            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: " .  $estado->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id != null && $request->socio_id != null  && $request->estado_id == null) {
            foreach ($reclamos as $rec) {
                if (($rec->tipoReclamo->id == $request->tipoReclamo_id) && ($rec->socio->id == $request->socio_id)) {
                    $aux->push($rec);
                }
            }

            $tipRec = TipoReclamo::find($request->tipoReclamo_id);
            $socio = Socio::find($request->socio_id);
            $filtro = "Filtros: " .  $tipRec->nombre . " y " . $socio->apellido . " " . $socio->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id != null && $request->socio_id == null  && $request->estado_id != null) {
            foreach ($reclamos as $rec) {
                if (($rec->tipoReclamo->id == $request->tipoReclamo_id) && ($rec->trabajo->estado->id == $request->estado_id)) {
                    $aux->push($rec);
                }
            }
            $tipRec = TipoReclamo::find($request->tipoReclamo_id);
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: " .  $tipRec->nombre . " y " . $estado->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id != null && $request->socio_id != null  && $request->estado_id != null) {
            foreach ($reclamos as $rec) {
                if (($rec->tipoReclamo->id == $request->tipoReclamo_id) && ($rec->socio->id == $request->socio_id) && ($rec->trabajo->estado->id == $request->estado_id)) {
                    $aux->push($rec);
                }
            }
            $tipRec = TipoReclamo::find($request->tipoReclamo_id);
            $socio = Socio::find($request->socio_id);
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: " .  $tipRec->nombre . " , " . $socio->apellido . " " . $socio->nombre  . " y " . $estado->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id == null && $request->socio_id != null  && $request->estado_id != null) {
            foreach ($reclamos as $rec) {
                if (($rec->socio->id == $request->socio_id) && ($rec->trabajo->estado->id == $request->estado_id)) {
                    $aux->push($rec);
                }
            }
            $socio = Socio::find($request->socio_id);
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: " . $socio->apellido . " " . $socio->nombre  . " y " . $estado->nombre;
        } else {
            $aux = $reclamos;
        }
        $config = Configuracion::first();
        $cant = sizeof($aux);
        $datos = date('d/m/Y');
        $pdf = PDF::loadView('pdf.reclamos', ['reclamos' => $aux, 'datos' => $datos, 'cant' => $cant, 'filtro' => $filtro, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream('reclamos.pdf');
    }

    public function asistenciasPDF(Request $request, User $empleado)
    {
        $aux = collect();
        $filtro = "";
        if ($request->fecha1 != null && $request->fecha2 != null) {
            foreach ($empleado->asistencias as $a) {
                $f = Carbon::create($a->dia);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if (($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) {
                    $aux->push($a);
                }
            }
            $filtro = "Filtros aplicados: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y');
        } else {
            $aux = $empleado->asistencias;
        }
        $config = Configuracion::first();
        $cant = sizeof($aux);
        $datos = date('d/m/Y');
        $pdf = PDF::loadView('pdf.asistencias', ['asistencias' => $aux, 'datos' => $datos, 'empleado' => $empleado, 'cant' => $cant, 'filtro' => $filtro, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream('asistencias.pdf');
    }

    public function pedidoPDF(Pedido $pedido)
    {
        $config = Configuracion::first();
        $cant = sizeof($pedido->detalles);
        $pdf = PDF::loadView('pdf.pedidos', ['pedido' => $pedido, 'cant' => $cant, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream('pedidos.pdf');
    }

    // public function productosMasUtilizadosPDF()
    // {

    //     $config = Configuracion::first();
    //     $cant = sizeof();
    //     $pdf = PDF::loadView('pdf.pedidos', ['pedido' => $pedido, 'cant' => $cant, 'config' => $config]);
    //     $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
    //     $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
    //     return $pdf->stream('pedidos.pdf');
    // }

    public function trabajosConMayorDuracionPDF()
    {

        $tipos = TipoReclamo::all()->where('flujoTrabajo_id',  1);
        $tipos = $tipos->sortByDesc('DuracionReal');
        $config = Configuracion::first();
        $cant = sizeof($tipos);
        $pdf = PDF::loadView('pdf.trabajosConMayorDuracion', ['trabajos' => $tipos, 'cant' => $cant, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream('trabajosConMayorDuracion.pdf');
    }

    public function trabajosMasFrecuentesPDF()
    {

        $tipos = TipoReclamo::all()->where('trabajo',  true);
        $tipos = $tipos->sortByDesc('frecuencia');
        $config = Configuracion::first();
        $cant = sizeof($tipos);
        $pdf = PDF::loadView('pdf.trabajosMasFrecuentes', ['trabajos' => $tipos, 'cant' => $cant, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream('trabajosMasFrecuentes.pdf');
    }

    public function trabajosPDF(Request $request)
    {

        $trabajos = Trabajo::all();
        $aux = collect();
        $filtro = "";
        if (($request->fecha1 != null && $request->fecha2 != null) && $request->tipoTrabajo_id == null && $request->empleado_id == null  && $request->estado_id == null) {
            foreach ($trabajos as $t) {
                $f = Carbon::create($t->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if (($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) {
                    $aux->push($t);
                }
            }
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y');
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->tipoTrabajo_id != null && $request->empleado_id == null && $request->estado_id == null) {
            foreach ($trabajos as $t) {
                $f = Carbon::create($t->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($t->reclamo->tipoReclamo->id == $request->tipoTrabajo_id)) {
                    $aux->push($t);
                }
            }
            $tipRec = TipoReclamo::find($request->tipoTrabajo_id);
            $filtro = "Filtros: -Fecha: desde:" . $fecha1->format('d/m/Y') . " hasta:" . $fecha2->format('d/m/Y') . ' -Tipo de Reclamo: ' . $tipRec->nombre;
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->tipoTrabajo_id == null && $request->empleado_id != null  && $request->estado_id == null) {
            foreach ($trabajos as $t) {
                $f = Carbon::create($t->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($t->users->contains('id', $request->empleado_id))) {
                    $aux->push($t);
                }
            }
            $empleado = User::find($request->empleado_id);
            $filtro = "Filtros: -Fecha: desde:" . $fecha1->format('d/m/Y') . " hasta:" . $fecha2->format('d/m/Y') . ' -Empleado: ' . $empleado->apellido . " " . $empleado->name;
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->tipoTrabajo_id == null && $request->empleado_id == null  && $request->estado_id != null) {
            foreach ($trabajos as $t) {
                $f = Carbon::create($t->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($t->estado->id == $request->estado_id)) {
                    $aux->push($t);
                }
            }
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: -Fecha: desde:" . $fecha1->format('d/m/Y') . " hasta:" . $fecha2->format('d/m/Y') . ' -Estado: ' . $estado->nombre;
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->tipoTrabajo_id != null && $request->empleado_id != null  && $request->estado_id != null) {
            foreach ($trabajos as $t) {
                $f = Carbon::create($t->fecha);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($t->reclamo->tipoReclamo->id == $request->tipoTrabajo_id) && ($t->users->contains('id', $request->empleado_id)) && ($t->estado->id == $request->estado_id)) {
                    $aux->push($t);
                }
            }
            $tipRec = TipoReclamo::find($request->tipoTrabajo_id);
            $empleado = User::find($request->empleado_id);
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: -Fecha: desde:" . $fecha1->format('d/m/Y') . " hasta:" . $fecha2->format('d/m/Y') . ' -Tipo de Reclamo: ' . $tipRec->nombre . ' -Estado: ' . $estado->nombre . ' -Empleado: ' . $empleado->apellido . " " . $empleado->name;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoTrabajo_id != null && $request->empleado_id == null  && $request->estado_id == null) {
            foreach ($trabajos as $t) {
                if ($t->reclamo->tipoReclamo->id == $request->tipoTrabajo_id) {
                    $aux->push($t);
                }
            }

            $tipRec = TipoReclamo::find($request->tipoTrabajo_id);
            $filtro = "Filtros: -Tipo de Reclamo: " . $tipRec->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoTrabajo_id == null && $request->empleado_id != null  && $request->estado_id == null) {
            foreach ($trabajos as $t) {
                if ($t->users->contains('id', $request->empleado_id)) {
                    $aux->push($t);
                }
            }
            $empleado = User::find($request->empleado_id);
            $filtro = "Filtros: -Empleado: " . $empleado->apellido . " " . $empleado->name;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoTrabajo_id == null && $request->empleado_id == null  && $request->estado_id != null) {
            foreach ($trabajos as $t) {
                if ($t->estado->id == $request->estado_id) {
                    $aux->push($t);
                }
            }

            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: -Estado" .  $estado->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoTrabajo_id != null && $request->empleado_id != null  && $request->estado_id == null) {
            foreach ($trabajos as $t) {
                if (($t->reclamo->tipoReclamo->id == $request->tipoTrabajo_id) && ($t->users->contains('id', $request->empleado_id))) {
                    $aux->push($t);
                }
            }

            $tipRec = TipoReclamo::find($request->tipoTrabajo_id);
            $empleado = User::find($request->empleado_id);
            $filtro = "Filtros: -Tipo de Reclamo: " .  $tipRec->nombre . " -Empleado: " . $empleado->apellido . " " . $empleado->name;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoTrabajo_id != null && $request->empleado_id == null  && $request->estado_id != null) {
            foreach ($trabajos as $t) {
                if (($t->reclamo->tipoReclamo->id == $request->tipoTrabajo_id) && ($t->estado->id == $request->estado_id)) {
                    $aux->push($t);
                }
            }
            $tipRec = TipoReclamo::find($request->tipoTrabajo_id);
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: -Tipo de Reclamo" .  $tipRec->nombre . " -Estado: " . $estado->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoTrabajo_id != null && $request->empleado_id != null  && $request->estado_id != null) {
            foreach ($trabajos as $t) {
                if (($t->reclamo->tipoReclamo->id == $request->tipoTrabajo_id) && ($t->users->contains('id', $request->empleado_id)) && ($t->estado->id == $request->estado_id)) {
                    $aux->push($t);
                }
            }
            $tipRec = TipoReclamo::find($request->tipoTrabajo_id);
            $empleado = User::find($request->empleado_id);
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: -Tipo de Reclamo: " .  $tipRec->nombre . " -Empleado: " . $empleado->apellido . " " . $empleado->name  . " -Estado: " . $estado->nombre;
        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tipoTrabajo_id == null && $request->empleado_id != null  && $request->estado_id != null) {
            foreach ($trabajos as $t) {
                if (($t->users->contains('id', $request->empleado_id)) && ($t->trabajo->estado->id == $request->estado_id)) {
                    $aux->push($t);
                }
            }
            $empleado = User::find($request->empleado_id);
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: -Empleado: " . $empleado->apellido . " " . $empleado->name  . " -Estado: " . $estado->nombre;
        } else {
            $aux = $trabajos;
        }
        $config = Configuracion::first();
        $cant = sizeof($aux);
        $datos = date('d/m/Y');
        $pdf = PDF::loadView('pdf.trabajos', ['trabajos' => $aux, 'datos' => $datos, 'cant' => $cant, 'filtro' => $filtro, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream('trabajos.pdf');
    }

    public function auditoriaPDF(Request $request)
    {

        $auditorias = Audit::all();
        $aux = collect();
        $filtro = "";
        if (($request->fecha1 != null && $request->fecha2 != null) && $request->tabla == null && $request->empleado_id == null) {
            foreach ($auditorias as $a) {
                $f = ($a->created_at);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if (($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) {
                    $aux->push($a);
                }
            }
            $filtro = "Filtros: -Fecha: desde:" . $fecha1->format('d/m/Y') . " hasta: " . $fecha2->format('d/m/Y');
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->tabla != null && $request->empleado_id == null) {
            if($request->tabla == 1){
                $tabla = 'Movimiento' ;
            }elseif($request->tabla == 2){
                $tabla = 'User' ;

            }elseif($request->tabla == 3){
                $tabla = 'Producto' ;
            }
            foreach ($auditorias as $a) {
                $f = $a->created_at;
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));
                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && (strpos($a->auditable_type,$tabla) !== false) ) {
                    $aux->push($a);
                }
            }
            if($request->tabla == 1){
                $tabla2 = 'MOVIMIENTOS' ;
            }elseif($request->tabla == 2){
                $tabla2 = 'EMPLEADOS' ;

            }elseif($request->tabla == 3){
                $tabla2 = 'PRODUCTOS' ;
            }
            $filtro = "Filtros: -Fecha: desde:" . $fecha1->format('d/m/Y') . " hasta: " . $fecha2->format('d/m/Y') . ' -Tabla ' . $tabla2;
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->tabla == null && $request->empleado_id != null) {
            foreach ($auditorias as $a) {
                $f = Carbon::create($a->created_at);
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($a->user_id == $request->empleado_id)) {
                    $aux->push($a);
                }
            }
            $empleado = User::find($request->empleado_id);
            $filtro = "Filtros: -Fecha: desde:" . $fecha1->format('d/m/Y') . " hasta: " . $fecha2->format('d/m/Y') . ' -Empleado: ' . $empleado->apellido . " " . $empleado->nombre;
        } elseif (($request->fecha1 != null && $request->fecha2 != null) && $request->tabla != null && $request->empleado_id != null) {
            if($request->tabla == 1){
                $tabla = 'Movimiento' ;
            }elseif($request->tabla == 2){
                $tabla = 'User' ;

            }elseif($request->tabla == 3){
                $tabla = 'Producto' ;
            }
            foreach ($auditorias as $a) {
                $f = $a->created_at;
                $fecha1 = Carbon::create($request->input('fecha1'));
                $fecha2 = Carbon::create($request->input('fecha2'));
                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && (strpos($a->auditable_type,$tabla) !== false) && ($a->user_id == $request->empleado_id) ) {
                    $aux->push($a);
                }
            }
            if($request->tabla == 1){
                $tabla2 = 'MOVIMIENTOS' ;
            }elseif($request->tabla == 2){
                $tabla2 = 'EMPLEADOS' ;

            }elseif($request->tabla == 3){
                $tabla2 = 'PRODUCTOS' ;
            }
            $empleado = User::find($request->empleado_id);
            $filtro = "Filtros: -Fecha: desde:" . $fecha1->format('d/m/Y') . " hasta: " . $fecha2->format('d/m/Y') . ' -Tabla ' . $tabla2 . ' -Empleado: ' . $empleado->apellido  .' ' . $empleado->name;

        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tabla != null && $request->empleado_id != null) {
            if($request->tabla == 1){
                $tabla = 'Movimiento' ;
            }elseif($request->tabla == 2){
                $tabla = 'User' ;

            }elseif($request->tabla == 3){
                $tabla = 'Producto' ;
            }
            foreach ($auditorias as $a) {
                if ((strpos($a->auditable_type,$tabla) !== false) && ($a->user_id == $request->empleado_id) ) {
                    $aux->push($a);
                }
            }
            if($request->tabla == 1){
                $tabla2 = 'MOVIMIENTOS' ;
            }elseif($request->tabla == 2){
                $tabla2 = 'EMPLEADOS' ;

            }elseif($request->tabla == 3){
                $tabla2 = 'PRODUCTOS' ;
            }
            $empleado = User::find($request->empleado_id);
            $filtro = "Filtros: -Tabla " . $tabla2 . ' -Empleado: ' . $empleado->apellido  .' ' . $empleado->name;

        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tabla == null && $request->empleado_id != null) {

            foreach ($auditorias as $a) {
                if ( ($a->user_id == $request->empleado_id) ) {
                    $aux->push($a);
                }
            }

            $empleado = User::find($request->empleado_id);
            $filtro = "Filtros: -Empleado: " . $empleado->apellido  .' ' . $empleado->name;

        } elseif (($request->fecha1 == null && $request->fecha2 == null) && $request->tabla != null && $request->empleado_id == null) {

            if($request->tabla == 1){
                $tabla = 'Movimiento' ;
            }elseif($request->tabla == 2){
                $tabla = 'User' ;

            }elseif($request->tabla == 3){
                $tabla = 'Producto' ;
            }
            foreach ($auditorias as $a) {
                if ((strpos($a->auditable_type,$tabla) !== false) ) {
                    $aux->push($a);
                }
            }
            if($request->tabla == 1){
                $tabla2 = 'MOVIMIENTOS' ;
            }elseif($request->tabla == 2){
                $tabla2 = 'EMPLEADOS' ;

            }elseif($request->tabla == 3){
                $tabla2 = 'PRODUCTOS' ;
            }
            $filtro = "Filtros: -Tabla " . $tabla2 ;
        } else {
            $aux = $auditorias;
        }

        $config = Configuracion::first();
        $cant = sizeof($aux);
        $datos = date('d/m/Y');
        $pdf = PDF::loadView('pdf.auditorias', ['auditorias' => $aux, 'datos' => $datos, 'cant' => $cant, 'filtro' => $filtro, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream('auditoria.pdf');
    }

    public function productosUtilizadosPDF(Request $request){
        $almacen = Almacen::find($request->almacen_id) ;
        $productos = collect() ;
        foreach($almacen->existencias as $e){
            $productos->add($e->producto) ;
        }

        for ($i = 1; $i < count($productos); $i++) {
            for ($j = 0; $j < count($productos) - $i; $j++) {
                if ($productos[$j]->cantidadUtilizada($almacen) < $productos[$j + 1]->cantidadUtilizada($almacen)) {
                        $k = $productos[$j + 1];
                        $productos[$j + 1] = $productos[$j];
                        $productos[$j] = $k;
                }
            }
        }

        $config = Configuracion::first();
        $cant = sizeof($productos);
        $datos = date('d/m/Y');
        $pdf = PDF::loadView('pdf.productosUtilizados', ['productos' => $productos, 'almacen' => $almacen, 'datos' => $datos, 'cant' => $cant, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream('productosUtilizados.pdf');
    }
}
