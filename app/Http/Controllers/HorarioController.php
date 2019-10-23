<?php

namespace App\Http\Controllers;

use App\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $horarios = Horario::all() ;
        return view('horario.index',  compact('horarios')) ;
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

        $horario = new Horario() ;
        $horario->fill($request->all()) ;
        $horario->save() ;

        return redirect('/horarios')->with('confirmar' , 'ok') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function show(Horario $horario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function edit(Horario $horario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Horario $horario)
    {

        $horario->fill($request->all()) ;
        $horario->update() ;

        return redirect('/horarios')->with('confirmar' , 'ok') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $horario = Horario::find($id) ;
        if($horario->turnos->isEmpty()){
            $horario->delete() ;
            return redirect('/horarios')->with('borrado' , 'ok');
        }else{
            alert()->error('No es posible eliminar el horario debido a que esta siendo utilizado!' , 'Error');
            return redirect()->back() ;
        }
    }
}
