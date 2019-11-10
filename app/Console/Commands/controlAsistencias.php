<?php

namespace App\Console\Commands;

use App\Asistencia;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class controlAsistencias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'control:asistencias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $empleados = User::all();
        foreach($empleados as $key => $e){
            if($e->roles->first()->name != 'EMPLEADO_PLANTA'){
                $empleados->pull($key) ;
            }
        }
        $hoy = Carbon::now()->dayOfWeek ;
        foreach($empleados as $e){
            if(!$e->getTurnos($hoy)->isEmpty()){
                if($e->getTurnos($hoy)->count() == 1 ){
                    $asisEmpleado = Asistencia::where('dia', Carbon::now()->format('Y-m-d'))->where('user_id' , $e->id)->get() ;
                    if($asisEmpleado->isEmpty()){
                        $asistencia = new Asistencia() ;
                        $asistencia->dia = Carbon::now() ;
                        $asistencia->presente = false ;
                        $asistencia->user_id = $e->id ;
                        $asistencia->save() ;
                    }
                }

            }

        }
    }
}
