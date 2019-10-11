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
        $comprobante->save();
        return redirect()->back()->withInput()->with('confirmar', 'bien') ;
    }


    public function update(Request $request, TipoComprobante $comprobante){

        $comprobante->fill($request->all()) ;
        $comprobante->update();
        return redirect()->back()->with('confirmar', 'bien') ;
    }

    public function destroy(TipoComprobante $comprobante){

        $comprobante->delete();
        return redirect()->back()->with('borrado', 'bien') ;

    }



    public function validar(){
        $data = request()->validate([
            'nombre' => 'required|unique:tipo_comprobantes,nombre' ,
        ]);
    }
}
