<?php

namespace App\Http\Controllers;

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
        $pdf=PDF::loadView('pdf.proveedor',['proveedores'=>$proveedores, 'datos'=> $datos]);
        return $pdf->stream('proveedor.pdf');

    }
}
