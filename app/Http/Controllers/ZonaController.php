<?php

namespace App\Http\Controllers;

use App\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ZonaController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:zonas,nombre',
        ], ['nombre.unique' => 'La zona ya existe']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(['tab' => 'zonas']);
        }

        $zona = new Zona();
        $zona->fill($request->all());
        $zona->save();
        return redirect()->back()->withInput(['tab' => 'zonas'])->with('confirmar', 'bien');
    }


    public function update(Request $request, Zona $zona)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:zonas,nombre,' . $zona->id,
        ], ['nombre.unique' => 'La zona ya existe']);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(['tab' => 'zonas']);
        }

        $zona->fill($request->all());
        $zona->update();
        return redirect()->back()->withInput(['tab' => 'zonas'])->with('confirmar', 'bien');
    }

    public function destroy(Zona $zona)
    {

        $zona->delete();
        return redirect()->back()->withInput(['tab' => 'zonas'])->with('borrado', 'bien');
    }
}
