<?php

namespace App\Http\Controllers;

use App\TipoMovimiento;
use Illuminate\Http\Request;

class TipoMovimientoController extends Controller
{
    public function store(Request $request){

        $this->validar();

        $tipoMov = new TipoMovimiento() ;
        $tipoMov->fill($request->all()) ;
        $tipoMov->save();
        return redirect()->back()->withInput()->with('confirmar', 'bien') ;
    }


    public function update(Request $request, TipoMovimiento $tipoMov){

        $tipoMov->fill($request->all()) ;
        $tipoMov->update();
        return redirect()->back()->with('confirmar', 'bien') ;
    }

    public function destroy(TipoMovimiento $tipoMov){

        if($tipoMov->id == 1 || $tipoMov->id == 2 || $tipoMov->id == 3){
            alert()->error('No es posible eliminar operaciones basicas del sistema' ,'Error')->persistent() ;
            return redirect()->back() ;
        }
        $tipoMov->delete();
        return redirect()->back()->with('borrado', 'bien') ;

    }


    public function validar(){
        $data = request()->validate([
            'nombre' => 'required|unique:tipo_movimientos,nombre' ,
        ]);
    }
}
