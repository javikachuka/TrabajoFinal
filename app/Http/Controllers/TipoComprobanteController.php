<?php

namespace App\Http\Controllers;

use App\TipoComprobante;
use Illuminate\Http\Request;

class TipoComprobanteController extends Controller
{
    public function store(Request $request){
        $this->validar();
        $comprobante = new TipoComprobante() ;
        $comprobante->fill($request->all()) ;
        return redirect()->back()->with('confirmar', 'bien') ;
    }


    public function update(Request $request, TipoComprobante $comprobante){

        $comprobante->fill($request->all()) ;
        return redirect()->back()->with('confirmar', 'bien') ;
    }



    public function validar(){
        $data = request()->validate([
            'nombre' => 'required|unique:tipo_comprobantes,nombre' ,
        ]);
    }
}
