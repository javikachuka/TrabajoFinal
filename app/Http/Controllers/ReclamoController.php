<?php

namespace App\Http\Controllers;

use App\Control;
use App\HistorialEstado;
use App\Reclamo;
use App\Requisito;
use Illuminate\Http\Request;
use App\TipoReclamo ;
use App\Socio ;
use App\Trabajo;
use App\Turno;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class ReclamoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reclamos = Reclamo::all();

        return view('reclamos.index',compact('reclamos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reclamo = new Reclamo() ;
        $socios = Socio::all() ;
        $tipos_reclamos = TipoReclamo::all() ;
        $reclamos = Reclamo::all() ;
        return view('reclamos.create' , compact('reclamo' ,'reclamos' , 'socios' , 'tipos_reclamos')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Reclamo $reclamo)
    {
        // DB::beginTransaction();
        // try{
            // return sizeof($request->requisitos) ;
            $reclamo->fill($request->only(['socio_id' ,'tipoReclamo_id' , 'fecha' , 'detalle'])) ;
            $reclamo->user_id = auth()->user()->id ;
            $reclamo->save() ;
            if($reclamo->tipoReclamo->trabajo == true){ // hay un atributo que es boolean (trabajo) y me dice si el reclamo conlleva o no un trabajo
                $trabajo = new Trabajo() ;
                $trabajo->fecha = $reclamo->fecha ;

                $trabajo->estado_id = $reclamo->tipoReclamo->flujoTrabajo->getEstadoInicial() ;

                $trabajo->save() ;
                $reclamo->trabajo_id = $trabajo->id ;
                $reclamo->update() ;
                $historial = new HistorialEstado();
                $historial->reclamo_id = $reclamo->id ;
                $historial->estado_id = $trabajo->estado_id ;
                $historial->save() ;

                if($request->requisitos != null){
                    for($i = 0 ;  $i < sizeof($request->requisitos) ; $i++){
                        $control = new Control() ;
                        $control->reclamo_id = $reclamo->id ;
                        $control->requisito_id = $request->requisitos[$i] ;
                        $control->save() ;
                    }
                    // if(sizeof($request->requisitos) != sizeof($reclamo->tipoReclamo->requisitos)){
                    //     $trabajo->estado_id = 6 ; //aqui deberia ir la logica para pasar a un estado faltante
                    //     $trabajo->update() ;
                    //     $hisFaltante = new HistorialEstado();
                    //     $hisFaltante->reclamo_id = $reclamo->id ;
                    //     $hisFaltante->estado_id = $trabajo->estado_id ;
                    //     $hisFaltante->save() ;
                    // }
                }

                $diaSemana = Carbon::create($request->fecha)->dayOfWeek ;
                //$turnosDisponibles = DB::table('turnos')->where('dia', 3)->get() ;

                $turnos = Turno::all() ;

                $valido = null ;
                foreach ($turnos as $id => $t){
                    if($t->dia == $diaSemana ){
                        $valido = $t ;
                    }
                }

                $trabajo->users()->sync($valido->users[0]->id) ;

            }
           // DB::commit();
            return redirect('/reclamos')->with('confirmar' , 'bien') ;

        // }catch(Exception $e){
        //     DB::rollback();
        //     return $e ;
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function show(Reclamo $reclamo)
    {
        return view('reclamos.show' , compact('reclamo')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function edit(Reclamo $reclamo)
    {
        $socios = Socio::all() ;
        $tipos_reclamos = TipoReclamo::all() ;
        $reclamos = Reclamo::all() ;
        return view('reclamos.edit' , compact('reclamo' , 'socios' , 'tipos_reclamos' , 'reclamos')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reclamo = Reclamo::find($id);
        $reclamo->fill($request->only(['socio_id' ,'tipoReclamo_id' , 'fecha' , 'detalle'])) ;
        $reclamo->update();
        if($request->requisitos != null){
            for($i = 0 ;  $i < sizeof($request->requisitos) ; $i++){
                $req = Requisito::find($request->requisitos[$i]) ;
                if(!$reclamo->presentoRequisito($req)){
                    $control = new Control() ;
                    $control->reclamo_id = $reclamo->id ;
                    $control->requisito_id = $request->requisitos[$i] ;
                    $control->save() ;
                }
            }
        }
        return redirect('/reclamos')->with('confirmar' , 'bien') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reclamo = Reclamo::find($id) ;
        try{
            if($reclamo != null){
                $reclamo->delete() ;
                return redirect()->back()->with('borrado' , 'ok') ;
            }
        }catch(Exception $e){
            alert()->error('No es posible eliminar' , 'Error!') ;
            return redirect('/reclamos') ;
        }
    }


}
