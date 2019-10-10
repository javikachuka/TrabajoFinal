<?php

namespace App\Http\Controllers;

use App\Horario;
use App\Turno;
use App\User;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $empleados = User::all() ;
        // return view('turnos.index' , compact('empleados')) ;
        $horarios = Horario::all() ;
        $empleados = User::all() ;
        return view('turnos.create' , compact('horarios' , 'empleados')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->empleado_id == null){
            alert()->error('Debe seleccionar un empleado' , 'Error') ;
            return redirect()->back() ;
        }
        if($request->dias == null || $request->horarios == null){
            alert()->error('Debe asignar dias y horarios' , 'Error') ;
            return redirect()->back() ;
        }

        $empleado = User::find($request->empleado_id);
        foreach($request->horarios as $horario){
            $horarioDisp = Horario::find($horario) ;
            foreach($request->dias as $dia){
                if($horarioDisp->existeTurno($dia)){
                    if(!$horarioDisp->getTurno($dia)->users->contains($empleado)){
                        $horarioDisp->getTurno($dia)->users()->attach($empleado->id) ;
                    }
                }else{
                    $turno = new Turno() ;
                    $turno->dia = $dia ;
                    $turno->horario_id = $horario ;
                    $turno->save() ;
                    $turno->users()->sync($empleado) ;
                }
            }
        }
        return redirect()->back()->withInput()->with('confirmar' , 'ok') ;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function show(Turno $turno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function edit(Turno $turno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Turno $turno)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function destroy($idturno , $idemple)
    {
        $empleado = User::find($idemple) ;
        $empleado->turnos()->detach($idturno) ;
        // $turno = Turno::find($idturno) ;
        // $turno->delete() ;
        return redirect()->back()->withInput()->with('confirmar' , 'ok') ;
    }

    public function obtenerTurnos($id){
        $empleado = User::find($id) ;
        $horarios = Horario::all() ;

        return ['turnos' => $empleado->turnos , 'horarios' => $horarios] ;
    }

    // public function validar(){
    //     $errors = request()->validate([
    //         'empleado_id' => 'required' ,
    //     ]);
    // }
}
