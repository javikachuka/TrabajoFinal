<?php

namespace App\Http\Controllers;

use App\TipoMovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TipoMovimientoController extends Controller
{
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:tipo_movimientos,nombre',
        ],['nombre.unique' => 'El tipo de movimiento ya existe']);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput(['tab'=>'movimientos']) ;
        }

        $tipoMov = new TipoMovimiento() ;
        $tipoMov->fill($request->all()) ;
        $tipoMov->save();
        return redirect()->back()->withInput(['tab'=>'movimientos'])->with('confirmar', 'bien') ;
    }


    public function update(Request $request, TipoMovimiento $tipoMov){

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:tipo_movimientos,nombre,' . $tipoMov->id,
        ],['nombre.unique' => 'El tipo de movimiento ya existe']);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput(['tab'=>'movimientos']) ;
        }

        $tipoMov->fill($request->all()) ;
        $tipoMov->update();
        return redirect()->back()->withInput(['tab'=>'movimientos'])->with('confirmar', 'bien') ;
    }

    public function destroy(TipoMovimiento $tipoMov){

        if($tipoMov->id == 1 || $tipoMov->id == 2 || $tipoMov->id == 3){
            alert()->error('No es posible eliminar operaciones basicas del sistema' ,'Error')->persistent() ;
            return redirect()->back()->withInput(['tab'=>'movimientos']) ;
        }
        $tipoMov->delete();
        return redirect()->back()->withInput(['tab'=>'movimientos'])->with('borrado', 'bien') ;

    }

}
