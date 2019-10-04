<?php

namespace App\Http\Controllers;

use App\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $dia = Carbon::now()->format('Y-m-d');
        $asistencia = new Asistencia();

        return view('asistencia.index', compact('user'));
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
     * @param  \App\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function show(Asistencia $asistencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Asistencia $asistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     *   @param  \App\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asistencia $asistencia)
    {
        //
    }

    public function entrada(Request $request){

        // $this->validar();

        $asisEmpleado = Asistencia::where('dia', Carbon::now()->format('Y-m-d'))->where('user_id' , auth()->user()->id)->get() ;
        $horaActual = Carbon::now()->format('H:i:s');
        if(!empty($asisEmpleado[0])){
            foreach($asisEmpleado as $asistencia){
                // && (strtotime($horaActual) <= strtotime($asistencia->horaSalida))
                if((strtotime($horaActual) >= strtotime($asistencia->horaEntrada)) ){
                    if($asistencia->horaSalida != null){
                        if(strtotime($horaActual) <= strtotime($asistencia->horaSalida)){
                            alert()->info('Usted ya ha marcado su entrada del dia') ;
                            return redirect()->back() ;
                        }
                    }else{
                        // $horaTrabajoNormal = "08:00:00" ;
                        // return  (strtotime($horaActual) - strtotime($asistencia->horaEntrada)) /3600 ;
                        if (((strtotime($horaActual) - strtotime($asistencia->horaEntrada)) / 3600) < 6.5){
                            alert()->info('Usted ya ha marcado su entrada del dia') ;
                            return redirect()->back() ;
                        }
                    }
                }
            }
        }
        $encoded_data = $_POST['fotoEntrada'];
        $binary_data = base64_decode( $encoded_data );
        $name = time().auth()->user()->name.auth()->user()->apellido.".png";
        $result = file_put_contents( public_path('/img/asistencias/').$name, $binary_data );
        if (!$result) {
            alert()->error('No se pudo almacenar la foto' , 'Error') ;
            return redirect()->back() ;
        }
        $asistencia = new Asistencia() ;
        $asistencia->dia = Carbon::now() ;
        $asistencia->horaEntrada  = Carbon::now('America/Argentina/Buenos_Aires')->format('H:i:s') ;
        $asistencia->urlFoto = $name ;
        $asistencia->presente = true ;
        $asistencia->user_id = auth()->user()->id ;
        $asistencia->save() ;

        return redirect()->back()->with('confirmar' , 'ok') ;

    }

    public function salida(){
        $asisEmpleado = Asistencia::where('dia', Carbon::now()->format('Y-m-d'))->where('user_id' , auth()->user()->id)->get() ;
        $horaActual = Carbon::now()->format('H:i:s');
        if(!empty($asisEmpleado[0])){
            foreach($asisEmpleado as $asistencia){
                if($asistencia->horaSalida == null){
                    // return (strtotime($horaActual) - strtotime($asistencia->horaEntrada))/3600 ;
                    if(((strtotime($horaActual) - strtotime($asistencia->horaEntrada))/3600) <= 8.5){
                        $asistencia->horaSalida = $horaActual ;
                        $asistencia->update() ;
                    }
                }
            }

            return redirect()->back()->with('confirmar' , 'ok') ;

        }else{
            alert()->error('Usted no ha marcado entrada!' , 'Error') ;
            return redirect()->back() ;
        }
    }

    public function validar(){
        return request()->validate([
            'fotoEntrada' => 'required' ,
        ]);
    }
}
