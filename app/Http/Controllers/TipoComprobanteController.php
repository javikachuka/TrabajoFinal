<?php

namespace App\Http\Controllers;

use App\TipoComprobante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoComprobanteController extends Controller
{
    public function store(Request $request)
    {
        // if($this->validar()->fails()){
        // return redirect()->back()->withInput(['tab'=>'comprobantes']) ;
        // }
        // $this->validate($request, [
        //     'nombre' => 'required|unique:tipo_comprobantes,nombre'
        // ], [ 'nombre.unique' => 'El tipo de comprobante ya existe' ] );
        // $this->validar();

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:tipo_comprobantes,nombre',
        ], ['nombre.unique' => 'El tipo de comprobante ya existe']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(['tab' => 'comprobantes']);
        }

        $comprobante = new TipoComprobante();
        $comprobante->fill($request->all());
        $comprobante->save();
        return redirect()->back()->withInput(['tab' => 'comprobantes'])->with('confirmar', 'bien');
    }


    public function update(Request $request, TipoComprobante $comprobante)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:tipo_comprobantes,nombre,' . $comprobante->id,
        ], ['nombre.unique' => 'El tipo de comprobante ya existe']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(['tab' => 'comprobantes']);
        }
        $comprobante->fill($request->all());
        $comprobante->update();
        return redirect()->back()->withInput(['tab' => 'comprobantes'])->with('confirmar', 'bien');
    }

    public function destroy(TipoComprobante $comprobante)
    {

        $comprobante->delete();
        return redirect()->back()->withInput(['tab' => 'comprobantes'])->with('borrado', 'bien');
    }



    // public function validar(){
    //     $data = request()->validate([
    //         'nombre' => 'required|unique:tipo_comprobantes,nombre' ,
    //     ]);
    //     return back()->withInput(['tab'=>'comprobantes']) ;
    // }
}
