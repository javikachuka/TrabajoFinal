<?php

namespace App\Http\Controllers;

use App\Requisito;
use Illuminate\Http\Request;

class RequisitoController extends Controller
{
    public function index(){
        $requisitos = Requisito::all() ;
        return view('requisitos.index' , compact('requisitos')) ;
    }

    public function store(Request $request){
        $requisito = new Requisito() ;
        $requisito->fill($request->all()) ;
        $requisito->save() ;
        return redirect()->route('requisitos.index')->with('confirmar', 'asd') ;
    }

    public function update(Request $request ,Requisito $requisito){
        $requisito->fill($request->all()) ;
        $requisito->update() ;
        return redirect()->route('requisitos.index')->with('confirmar', 'asd') ;
    }

    public function destroy(Requisito $requisito){
        $requisito->delete() ;
        return redirect()->route('requisitos.index')->with('borrado', 'asd') ;
    }


}
