<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Trabajo extends Model
{
    use SoftDeletes ;

    public function estado(){
        return $this->belongsTo(Estado::class);
    }

    public function reclamo(){
        return $this->hasOne(Reclamo::class);
    }

    public function socio(){
        return $this->belongsTo(Socio::class);
    }

    public function cabecerasMovimientos(){
        return $this->hasMany(CabeceraMovimiento::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function getFecha(){
        $date = Carbon::create($this->fecha)->format('d/m/Y') ;
        return $date  ;
    }

    public function diferencia(){
        $inicio = Carbon::create($this->horaInicio) ;
        return $inicio->diffForHumans() ;
    }

    public function ultimoEstado(){
        return $this->updated_at->diffForHumans() ;
    }

    public function tiempoDuracion(){
        $inicio = Carbon::create($this->horaInicio) ;
        $fin = Carbon::create($this->horaFin) ;
        $resul = round($inicio->diffInMinutes($fin)/60, 2) ;
        return  str_replace('.', ':' , $resul ) ;

    }

    public function tiempoDuracionEstimado($tipoTrabajo){
        $trabajos = Trabajo::all();
        $suma = 0 ;
        $div = 0;
        foreach($trabajos as $trabajo){
            if($trabajo->reclamo->tipoReclamo->id == $tipoTrabajo){
                if($trabajo->horaFin != null){
                    $inicio = Carbon::create($trabajo->horaInicio) ;
                    $fin = Carbon::create($trabajo->horaFin) ;
                    $suma += $inicio->diffInMinutes($fin)/60 ;
                    $div += 1 ;
                }
            }
        }
        $resul = $suma/$div ;
        $enHoras = round($resul, 2) ;
        return str_replace('.', ':' , $enHoras ) ;
    }

}
