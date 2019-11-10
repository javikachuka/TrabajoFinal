<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use Notifiable;
    use HasRolesAndPermissions;
    Use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name'
    //     // 'apellido',
    //     // 'dni',
    //     // 'domicilio_id',
    //     // 'fecha_ingreso',
    //     // 'telefono',
    //     // 'email',
    //     // 'password'
    // ];

    protected $guarded = [
        'password',
        'domicilio_id'
    ] ;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function setApellidoAttribute($value)
    {
        $this->attributes['apellido'] = ucwords($value);
    }


    public function direccion(){
        return $this->belongsTo(Direccion::class) ;
    }

    public function reclamos(){
        return $this->hasMany(Reclamo::class);
    }

    public function asistencias(){
        return $this->hasMany(Asistencia::class);
    }

    public function turnos(){
        return $this->belongsToMany(Turno::class);
    }

    public function trabajos(){
        return $this->belongsToMany(Trabajo::class);
    }

    public function pedidos(){
        return $this->hasMany(Pedido::class);
    }

    public function getFecha(){
        $date = Carbon::create($this->fecha_ingreso)->format('d/m/Y') ;
        return $date  ;
    }

    public function deTurno(){
        $hoy = Carbon::now() ;
        $hoy->setTime(0,0,0);
        $asistencias = $this->asistencias;
        foreach($asistencias as $asistencia){
            $otro = Carbon::createFromFormat('Y-m-d',$asistencia->dia) ;
            $otro->setTime(0,0,0) ;
            if($otro->equalTo($hoy)){
                $horaActual = Carbon::now()->format('H:i:s');
                if($asistencia->horaSalida == null){
                    if( (strtotime($horaActual) > strtotime($asistencia->horaEntrada)) && ((abs(strtotime($horaActual) - strtotime($asistencia->horaEntrada)) / 3600) < 8.0)){
                        return true ;
                    }
                }
            }
        }
        return false ;
    }

    public function getHorario(Asistencia $asistencia){
        $horarios = Horario::all();
        if($asistencia->horaEntrada != null){
            $horaEntrada = Carbon::create($asistencia->horaEntrada) ;
            foreach($horarios as $horario){
                $horaE = Carbon::create($horario->horaEntrada)->subMinutes(15);
                $horaS = Carbon::create($horario->horaSalida);
                if(($horaEntrada->greaterThanOrEqualTo($horaE) && $horaEntrada->lessThanOrEqualTo($horaS))){
                    return $horario;
                }
            }
        }else{
            foreach($this->turnos as $t){
                if($t->dia == $asistencia->getNumeroDeDia()){
                    return $t->horario ;
                }
            }
        }
    }

    public function marcoEntrada(){
        $turnos = $this->turnos;
        $hoy = Carbon::now()->dayOfWeek ;
        $horaActual = Carbon::now();
        foreach($turnos as $t){
            if($t->dia == $hoy){
                $horaEntrada =  Carbon::create($t->horario->horaEntrada)->subMinutes(15) ;
                $horaSalida =  Carbon::create($t->horario->horaSalida)->addMinutes(15) ;
                if($horaActual->greaterThanOrEqualTo($horaEntrada) && $horaActual->lessThanOrEqualTo($horaSalida)){
                    $asisEmpleado = Asistencia::where('dia', Carbon::now()->format('Y-m-d'))->where('user_id' , $this->id)->get() ;
                    if(!$asisEmpleado->isEmpty()){
                        foreach($asisEmpleado as $a){
                            $entrada = Carbon::create($a->horaEntrada) ;
                            if($a->horaSalida != null){
                                $salida = Carbon::create($a->horaSalida) ;

                                if($horaActual->greaterThanOrEqualTo($entrada) && $horaActual->lessThanOrEqualTo($salida)){
                                    return true ;
                                }else{
                                    if(sizeof($asisEmpleado) == 1){
                                        return false ;
                                    }
                                }
                            }else{
                                if($horaActual->diffInHours($entrada) < 4){
                                    return true ;
                                }
                            }

                        }
                    }else{
                        return false;
                    }
                    return false ;
                }
            }
        }
        return null ;
    }

    public function getTurnos($dia){
        $turnos = collect() ;
        foreach($this->turnos as $t){
            if($t->dia == $dia){
                $turnos->add($t) ;
            }
        }
        return $turnos ;
    }
}
