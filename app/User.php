<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
    use HasRolesAndPermissions;

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

    public function deTurno(){
        $hoy = Carbon::now() ;
        $hoy->setTime(0,0,0);
        $asistencias = $this->asistencias;
        foreach($asistencias as $asistencia){
            $otro = Carbon::createFromFormat('Y-m-d',$asistencia->dia) ;
            $otro->setTime(0,0,0) ;
            if($otro->equalTo($hoy)){
                return true ;
            }
        }
        return false ;
    }
}
