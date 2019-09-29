<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $guarded = [] ;

    public function turnos(){
        return $this->hasMany(Turno::class);
    }

    public function existeTurno($dia){
        foreach($this->turnos as $tur){
            if($tur->dia == $dia){
                return true ;
            }
        }
        return false ;
    }

    public function getTurno($dia){
        foreach($this->turnos as $tur){
            if($tur->dia == $dia){
                return $tur ;
            }
        }
    }
}
