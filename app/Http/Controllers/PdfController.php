<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\Estado;
use App\Movimiento;
use App\Producto;
use App\Proveedor;
use App\Reclamo;
use App\Socio;
use App\TipoMovimiento;
use App\TipoReclamo;
use App\Trabajo;
use Illuminate\Http\Request;
use PDF ;
use DB ;
use Illuminate\Support\Carbon;

class PdfController extends Controller
{

    public function proveedorPDF()
    {
        $proveedores= Proveedor::all() ;
        $datos = date('d/m/Y');
        $cant = sizeof($proveedores) ;
        $config = Configuracion::first();
        $pdf=PDF::loadView('pdf.proveedor',['proveedores'=>$proveedores, 'datos'=> $datos , 'cant' => $cant , 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35 ;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y , "Pagina {PAGE_NUM} de {PAGE_COUNT}", null , 10 , array(0,0,0)) ;
        return $pdf->stream('proveedor.pdf');

    }

    public function movimientosPDF(Request $request){

        $movimientos = Movimiento::all() ;
        $aux = collect() ;
        $filtro = "" ;
        if(($request->fecha1 != null && $request->fecha2 != null) && $request->producto_id == null && $request->tipoMovimiento_id == null){
            foreach($movimientos as $mov){
                $f = Carbon::create($mov->cabeceraMovimiento->fecha) ;
                $fecha1 = Carbon::create($request->input('fecha1')) ;
                $fecha2 = Carbon::create($request->input('fecha2')) ;

                if (($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))){
                    $aux->push($mov) ;
                }
            }
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') ;
        } elseif(($request->fecha1 != null && $request->fecha2 != null) && $request->producto_id != null && $request->tipoMovimiento_id == null){
            foreach($movimientos as $mov){
                $f = Carbon::create($mov->cabeceraMovimiento->fecha) ;
                $fecha1 = Carbon::create($request->input('fecha1')) ;
                $fecha2 = Carbon::create($request->input('fecha2')) ;

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($mov->producto->id == $request->producto_id)){
                    $aux->push($mov) ;
                }

            }
            $prod = Producto::find($request->producto_id) ;
            $filtro = "Filtros: ". $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . ' y ' . $prod->nombre ;

        }elseif(($request->fecha1 != null && $request->fecha2 != null) && $request->producto_id == null && $request->tipoMovimiento_id != null){
            foreach($movimientos as $mov){
                $f = Carbon::create($mov->cabeceraMovimiento->fecha) ;
                $fecha1 = Carbon::create($request->input('fecha1')) ;
                $fecha2 = Carbon::create($request->input('fecha2')) ;

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($mov->tipoMovimiento->id == $request->tipoMovimiento_id)){
                    $aux->push($mov) ;
                }

            }
            $tipM = TipoMovimiento::find($request->tipoMovimiento_id);
            $filtro = "Filtros: ". $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . ' e ' . $tipM->nombre ;

        }elseif(($request->fecha1 != null && $request->fecha2 != null) && $request->producto_id != null && $request->tipoMovimiento_id != null){
            foreach($movimientos as $mov){
                $f = Carbon::create($mov->cabeceraMovimiento->fecha) ;
                $fecha1 = Carbon::create($request->input('fecha1')) ;
                $fecha2 = Carbon::create($request->input('fecha2')) ;

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($mov->tipoMovimiento->id == $request->tipoMovimiento_id) && ($mov->producto->id == $request->producto_id)){
                    $aux->push($mov) ;
                }

            }
            $prod = Producto::find($request->producto_id) ;
            $tipM = TipoMovimiento::find($request->tipoMovimiento_id);
            $filtro = "Filtros: ". $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . " , " . $tipM->nombre . " y " . $prod->nombre;

        }elseif(($request->fecha1 == null && $request->fecha2 == null) && $request->producto_id != null && $request->tipoMovimiento_id != null){
            foreach($movimientos as $mov){
                if (($mov->tipoMovimiento->id == $request->tipoMovimiento_id) && ($mov->producto->id == $request->producto_id)){
                    $aux->push($mov) ;
                }
            }

            $prod = Producto::find($request->producto_id) ;
            $tipM = TipoMovimiento::find($request->tipoMovimiento_id);
            $filtro = "Filtros: " . $tipM->nombre . " y " . $prod->nombre;

        }elseif(($request->fecha1 == null && $request->fecha2 == null) && $request->producto_id == null && $request->tipoMovimiento_id != null){
            foreach($movimientos as $mov){
                if ($mov->tipoMovimiento->id == $request->tipoMovimiento_id){
                    $aux->push($mov) ;
                }
            }
            $tipM = TipoMovimiento::find($request->tipoMovimiento_id);
            $filtro = "Filtros: " . $tipM->nombre;
        }elseif(($request->fecha1 == null && $request->fecha2 == null) && $request->producto_id != null && $request->tipoMovimiento_id == null){
            foreach($movimientos as $mov){
                if ($mov->producto->id == $request->producto_id){
                    $aux->push($mov) ;
                }
            }

            $prod = Producto::find($request->producto_id) ;
            $filtro = "Filtros: " .  $prod->nombre;
        }else{
            $aux = $movimientos ;
        }
        $config = Configuracion::first();
        $cant = sizeof($aux) ;
        $datos = date('d/m/Y');
        $pdf=PDF::loadView('pdf.movimientos',['movimientos'=>$aux, 'datos'=> $datos, 'cant' => $cant , 'filtro' => $filtro, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35 ;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y , "Pagina {PAGE_NUM} de {PAGE_COUNT}", null , 10 , array(0,0,0)) ;
        return $pdf->stream('movimientos.pdf');
    }

    public function trabajosPorHacerPDF(){
        $trabajos = Trabajo::all();
        foreach($trabajos as $key => $trabajo){
            if($trabajo->reclamo->getCantidadEstados() != 2){
                $trabajos->pull($key) ;
            }
            if(sizeof($trabajo->reclamo->tipoReclamo->requisitos) != sizeof($trabajo->reclamo->controles)){
                $trabajos->pull($key) ;
            }
        }
        $cant = sizeof($trabajos) ;
        $config = Configuracion::first();
        $pdf=PDF::loadView('pdf.trabajosPorHacer',['trabajos'=>$trabajos, 'cant' => $cant , 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35 ;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y , "Pagina {PAGE_NUM} de {PAGE_COUNT}", null , 10 , array(0,0,0)) ;
        return $pdf->stream('trabajosPorHacer.pdf');
    }

    public function reclamosPDF(Request $request){

        $reclamos = Reclamo::all() ;
        $aux = collect() ;
        $filtro = "" ;
        if(($request->fecha1 != null && $request->fecha2 != null) && $request->tipoReclamo_id == null && $request->socio_id == null  && $request->estado_id == null){
            foreach($reclamos as $rec){
                $f = Carbon::create($rec->fecha) ;
                $fecha1 = Carbon::create($request->input('fecha1')) ;
                $fecha2 = Carbon::create($request->input('fecha2')) ;

                if (($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))){
                    $aux->push($rec) ;
                }
            }
            $filtro = "Filtros: " . $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') ;
        } elseif(($request->fecha1 != null && $request->fecha2 != null) && $request->tipoReclamo_id != null && $request->socio_id == null && $request->estado_id == null){
            foreach($reclamos as $rec){
                $f = Carbon::create($rec->fecha) ;
                $fecha1 = Carbon::create($request->input('fecha1')) ;
                $fecha2 = Carbon::create($request->input('fecha2')) ;

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($rec->tipoReclamo->id == $request->tipoReclamo_id)){
                    $aux->push($rec) ;
                }

            }
            $tipRec = TipoReclamo::find($request->tipoReclamo_id) ;
            $filtro = "Filtros: ". $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . ' y ' . $tipRec->nombre ;

        }elseif(($request->fecha1 != null && $request->fecha2 != null) && $request->tipoReclamo_id == null && $request->socio_id != null  && $request->estado_id == null){
            foreach($reclamos as $rec){
                $f = Carbon::create($rec->fecha) ;
                $fecha1 = Carbon::create($request->input('fecha1')) ;
                $fecha2 = Carbon::create($request->input('fecha2')) ;

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($rec->socio->id == $request->socio_id)){
                    $aux->push($rec) ;
                }

            }
            $socio = Socio::find($request->socio_id);
            $filtro = "Filtros: ". $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . " y "  . $socio->apellido . " " . $socio->nombre;
        }elseif(($request->fecha1 != null && $request->fecha2 != null) && $request->tipoReclamo_id == null && $request->socio_id == null  && $request->estado_id != null){
            foreach($reclamos as $rec){
                $f = Carbon::create($rec->fecha) ;
                $fecha1 = Carbon::create($request->input('fecha1')) ;
                $fecha2 = Carbon::create($request->input('fecha2')) ;

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($rec->trabajo->estado->id == $request->estado_id)){
                    $aux->push($rec) ;
                }

            }
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: ". $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . " y " . $estado->nombre ;

        }elseif(($request->fecha1 != null && $request->fecha2 != null) && $request->tipoReclamo_id != null && $request->socio_id != null  && $request->estado_id != null){
            foreach($reclamos as $rec){
                $f = Carbon::create($rec->fecha) ;
                $fecha1 = Carbon::create($request->input('fecha1')) ;
                $fecha2 = Carbon::create($request->input('fecha2')) ;

                if ((($f->greaterThanOrEqualTo($fecha1)) && ($f->lessThanOrEqualTo($fecha2))) && ($rec->tipoReclamo->id == $request->tipoReclamo_id) && ($rec->socio->id == $request->socio_id) && ($rec->trabajo->estado->id == $request->estado_id)){
                    $aux->push($rec) ;
                }

            }
            $tipRec = TipoReclamo::find($request->tipoReclamo_id) ;
            $socio = Socio::find($request->socio_id);
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: ". $fecha1->format('d/m/Y') . " a " . $fecha2->format('d/m/Y') . " , " . $tipRec->nombre . " , " . $socio->apellido . " " . $socio->nombre  . " y " . $estado->nombre;

        }elseif(($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id != null && $request->socio_id == null  && $request->estado_id == null){
            foreach($reclamos as $rec){
                if ($rec->tipoReclamo->id == $request->tipoReclamo_id){
                    $aux->push($rec) ;
                }
            }

            $tipRec = TipoReclamo::find($request->tipoReclamo_id) ;
            $filtro = "Filtros: " . $tipRec->nombre ;

        }elseif(($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id == null && $request->socio_id != null  && $request->estado_id == null){
            foreach($reclamos as $rec){
                if ($rec->socio->id == $request->socio_id){
                    $aux->push($rec) ;
                }
            }
            $socio = Socio::find($request->socio_id);
            $filtro = "Filtros: " . $socio->apellido . " " . $socio->nombre;
        }elseif(($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id == null && $request->socio_id == null  && $request->estado_id != null){
            foreach($reclamos as $rec){
                if ($rec->trabajo->estado->id == $request->estado_id){
                    $aux->push($rec) ;
                }
            }

            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: " .  $estado->nombre;
        }elseif(($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id != null && $request->socio_id != null  && $request->estado_id == null){
            foreach($reclamos as $rec){
                if (($rec->tipoReclamo->id == $request->tipoReclamo_id) && ($rec->socio->id == $request->socio_id)){
                    $aux->push($rec) ;
                }
            }

            $tipRec = TipoReclamo::find($request->tipoReclamo_id) ;
            $socio = Socio::find($request->socio_id);
            $filtro = "Filtros: " .  $tipRec->nombre . " y " . $socio->apellido . " " . $socio->nombre;
        }elseif(($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id != null && $request->socio_id == null  && $request->estado_id != null){
            foreach($reclamos as $rec){
                if (($rec->tipoReclamo->id == $request->tipoReclamo_id) && ($rec->trabajo->estado->id == $request->estado_id)){
                    $aux->push($rec) ;
                }
            }
            $tipRec = TipoReclamo::find($request->tipoReclamo_id) ;
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: " .  $tipRec->nombre . " y " . $estado->nombre;
        }elseif(($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id != null && $request->socio_id != null  && $request->estado_id != null){
            foreach($reclamos as $rec){
                if (($rec->tipoReclamo->id == $request->tipoReclamo_id) && ($rec->socio->id == $request->socio_id) && ($rec->trabajo->estado->id == $request->estado_id)){
                    $aux->push($rec) ;
                }
            }
            $tipRec = TipoReclamo::find($request->tipoReclamo_id) ;
            $socio = Socio::find($request->socio_id);
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: ".  $tipRec->nombre . " , " . $socio->apellido . " " . $socio->nombre  . " y " . $estado->nombre;

        }elseif(($request->fecha1 == null && $request->fecha2 == null) && $request->tipoReclamo_id == null && $request->socio_id != null  && $request->estado_id != null){
            foreach($reclamos as $rec){
                if (($rec->socio->id == $request->socio_id) && ($rec->trabajo->estado->id == $request->estado_id)){
                    $aux->push($rec) ;
                }
            }
            $socio = Socio::find($request->socio_id);
            $estado = Estado::find($request->estado_id);
            $filtro = "Filtros: ". $socio->apellido . " " . $socio->nombre  . " y " . $estado->nombre;
        }else{
            $aux = $reclamos ;
        }
        $config = Configuracion::first();
        $cant = sizeof($aux) ;
        $datos = date('d/m/Y');
        $pdf=PDF::loadView('pdf.reclamos',['reclamos'=>$aux, 'datos'=> $datos, 'cant' => $cant , 'filtro' => $filtro, 'config' => $config]);
        $y = $pdf->getDomPDF()->get_canvas()->get_height() - 35 ;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y , "Pagina {PAGE_NUM} de {PAGE_COUNT}", null , 10 , array(0,0,0)) ;
        return $pdf->stream('reclamos.pdf');

    }
}
