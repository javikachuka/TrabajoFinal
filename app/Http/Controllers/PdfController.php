<?php

namespace App\Http\Controllers;

use App\Movimiento;
use App\Proveedor;
use Illuminate\Http\Request;
use PDF ;
use DB ;

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

    public function movimientosPDF(){
        $movimientos = Movimiento::all() ;
        $cant = sizeof($movimientos) ;
        $datos = date('d/m/Y');
        $pdf=PDF::loadView('pdf.movimientos',['movimientos'=>$movimientos, 'datos'=> $datos, 'cant' => $cant]);
        return $pdf->stream('movimientos.pdf');
    }
}
