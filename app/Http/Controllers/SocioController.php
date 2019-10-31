<?php

namespace App\Http\Controllers;

use App\Socio;
use App\Barrio;
use App\Direccion;
use App\Zona;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input as IlluminateInput;
use Illuminate\Support\Facades\Validator;

class SocioController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socios = Socio::all();
        $zonas = Zona::all();
        return view('socios.index', compact('socios', 'zonas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zonas = Zona::all();

        return view('socios.registro', compact('zonas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return count($request->input('calle')) ;


        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => 'required|string|min:10',
            'nro_conexion.*' => 'required|unique:direcciones,nro_conexion',
        ], [
            'nro_conexion.*.unique' => 'El numero de conexion ya esta asignado a un socio',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('cant', count($request->input('calle')))->withInput();
        }

        $socio = new Socio();
        $socio->apellido = $request->input('apellido');
        $socio->nombre = $request->input('nombre');
        $socio->dni = $request->input('dni');
        $socio->save();

        for ($i = 0; $i < sizeof($request->input('calle')); $i++) {
            $direccion = new Direccion();
            $direccion->zona_id = $request->zona_id[$i];
            $direccion->calle = $request->calle[$i];
            $direccion->altura = $request->altura[$i];
            $direccion->nro_conexion = $request->nro_conexion[$i];
            $direccion->socio_id = $socio->id;
            $direccion->save();
        }

        return redirect()->route('socios.index')->with('confirmar', 'ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $socio = Socio::find($id);
        return view('socios.show', compact('socio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function edit(Socio $socio)
    {
        $zonas = Zona::all();
        return view('socios.edit', compact('socio', 'zonas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Socio $socio)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => 'required|string|min:10',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $socio->fill($request->all());
        $socio->update();

        return redirect()->back()->with('confirmar', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Socio $socio)
    {
        try {
            $socio->delete();
            return redirect()->back()->with('borrado', 'ok');
        } catch (Exception $e) {
            alert()->error('No se pudo borrar al socio', 'Error');
            return redirect()->back();
        }
    }

    public function nuevaConexion(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nro_conexion' => 'required|unique:direcciones,nro_conexion',
        ], [
            'nro_conexion.unique' => 'El numero de conexion ya esta asignado a un socio',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $direccion = new Direccion();
        $direccion->fill($request->all());
        $direccion->socio_id = $request->socio_id;
        $direccion->nro_conexion = $request->nro_conexion;
        $direccion->save();

        return redirect()->back()->with('confirmar', 'ok');
    }

    public function eliminarConexion($id, $idDirec)
    {
        $socio = Socio::find($id);
        if (count($socio->direcciones) > 1) {
            foreach ($socio->direcciones as $d) {
                if ($d->id == $idDirec) {
                    $d->delete();
                    return redirect()->back()->with('borrado', 'ok');
                }
            }
        } else {
            alert()->error('No es posible eliminar todas las conexiones', 'Error')->persistent();
            return redirect()->back();
        }
    }

    public function validar()
    {
        $data = request()->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => 'required|string|min:10',
            'nro_conexion.*' => 'required|unique:direcciones,nro_conexion',
        ], [
            'nro_conexion.unique' => 'El numero de conexion ya esta asignado a un socio',
        ]);
    }

    public function obtenerConexiones($id)
    {
        $socio = Socio::find($id);
        $conexiones = collect();
        foreach ($socio->direcciones as $direc) {
            $conexiones->add($direc->nro_conexion);
        }
        return $conexiones;
    }

    public function obtenerDni($id)
    {
        $socio = Socio::find($id);
        return $socio->dni;
    }
}
