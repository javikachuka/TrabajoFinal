<?php

namespace App\Http\Controllers;

use App\Requisito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RequisitoController extends Controller
{
    public function index()
    {
        $requisitos = Requisito::all();
        return view('requisitos.index', compact('requisitos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:requisitos,nombre',
        ], ['nombre.unique' => 'El requisito ya existe']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $requisito = new Requisito();
        $requisito->fill($request->all());
        $requisito->save();
        return redirect()->route('requisitos.index')->with('confirmar', 'asd');
    }

    public function update(Request $request, Requisito $requisito)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:requisitos,nombre,'. $requisito->id,
        ], ['nombre.unique' => 'El requisito ya existe']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $requisito->fill($request->all());
        $requisito->update();
        return redirect()->route('requisitos.index')->with('confirmar', 'asd');
    }

    public function destroy(Requisito $requisito)
    {

        if ($requisito->tipoReclamos->isEmpty()) {
            $requisito->delete();
            return redirect()->route('requisitos.index')->with('borrado', 'asd');
        } else {
            alert()->error('No es posible eliminar el requisito debido a hay reclamos que lo utilizan', 'Error');
            return redirect()->back();
        }
    }
}
