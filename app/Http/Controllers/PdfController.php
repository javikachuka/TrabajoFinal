<?php

namespace App\Http\Controllers;

use App\Movimiento;
use App\Proveedor;
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
        $pdf=PDF::loadView('pdf.proveedor',['proveedores'=>$proveedores, 'datos'=> $datos , 'cant' => $cant]);
        return $pdf->stream('proveedor.pdf');

    }

    public function movimientosPDF(Request $request){
        $movimientos = Movimiento::all() ;
        if($request->fecha1 != null && $request->fecha2 != null){
            foreach($movimientos as $id => $mov){
                $f = Carbon::create($mov->cabeceraMovimiento->fecha) ;
                $fecha1 = Carbon::create($request->input('fecha1')) ;
                $fecha2 = Carbon::create($request->input('fecha2')) ;

                if (($f->lessThan($fecha1)) || ($f->greaterThan($fecha2))){
                    $movimientos->pull($id) ;
                }
            }
        }
        $cant = sizeof($movimientos) ;
        $datos = date('d/m/Y');
        $pdf=PDF::loadView('pdf.movimientos',['movimientos'=>$movimientos, 'datos'=> $datos, 'cant' => $cant]);
        return $pdf->stream('movimientos.pdf');
    }
}
