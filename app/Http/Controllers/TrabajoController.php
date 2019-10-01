<?php

namespace App\Http\Controllers;

use App\HistorialEstado;
use App\Trabajo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trabajos = Trabajo::all() ;
        $estados = collect() ;
        if(!empty($trabajos)){
            $estados = $trabajos[0]->reclamo->tipoReclamo->flujoTrabajo->getEstados() ;
        }
        return view('trabajos.index' , compact('trabajos', 'estados' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function show(Trabajo $trabajo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function edit(Trabajo $trabajo)
    {
        $empleados = User::all() ;
        return view('trabajos.asignacionTrabajos', compact('trabajo', 'empleados')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trabajo $trabajo)
    {
        if($request->empleados != null){
            $trabajo->users()->sync($request->input('empleados', [])) ;
            return redirect()->route('trabajos.index')->with('confirmar' , 'ok') ;
        }else{
            alert()->error('Por favor seleccione un/os empleado/s para asignar el trabajo', 'Error!') ;
            return redirect()->back() ;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trabajo $trabajo)
    {
        //
    }

    public function inicio(Trabajo $trabajo){

        if(sizeof($trabajo->reclamo->tipoReclamo->requisitos) == sizeof($trabajo->reclamo->controles)){
            if(!empty($trabajo->users[0])){
                if($trabajo->users->contains(auth()->user())) {
                    $siguienteEstado = $trabajo->reclamo->tipoReclamo->flujoTrabajo->siguienteEstado($trabajo->estado) ;
                    $trabajo->estado_id = $siguienteEstado->id ;
                    $trabajo->update() ;
                    $historial = new HistorialEstado() ;
                    $historial->reclamo_id = $trabajo->reclamo->id ;
                    $historial->estado_id = $siguienteEstado->id ;
                    $historial->save() ;
                    return redirect()->back()->with('confirmar', 'ok') ;
                }else{
                    alert()->error('Solamente el personal designado puede realizar este trabajo!')->persistent('Ok') ;
                    return redirect()->route('trabajos.index') ;
                }
            }else{
                return view('trabajos.inicio' , compact('trabajo')) ;
            }
        }else{
            alert()->error('No es posible comenzar el trabajo debido a que hay documentaciones sin presentar!')->persistent('Ok') ;
            return redirect()->route('trabajos.index') ;
        }
    }

}
