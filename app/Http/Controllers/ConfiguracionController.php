<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuracion;
use App\TipoComprobante;
use App\TipoMovimiento;
use App\Zona;

class ConfiguracionController extends Controller
{
    public function index()
    {

        $config = Configuracion::first();
        $comprobantes = TipoComprobante::all() ;
        $tipoMovimientos = TipoMovimiento::all();
        $zonas = Zona::all();
        return view('configuraciones.configuracion', compact('config' , 'comprobantes' , 'tipoMovimientos' , 'zonas'));
    }

    public function update(Request $request)
    {

        $config = Configuracion::first();
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path('/img/'), $name);
            $config->logo = $name;
        }

        $config->fill($request->all());
        $config->update();

        return redirect()->back()->with('confirmar', 'ok');
    }
}
