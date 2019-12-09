<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function horario(){
        return $this->belongsTo(Horario::class);
    }

    public function getNombreDia(){
        switch($this->dia){
            case 0:
                return 'Domingo' ;
            case 1:
                return 'Lunes' ;
            case 2:
                return 'Martes' ;
            case 3:
                return 'Miercoles' ;
            case 4:
                return 'Jueves' ;
            case 5:
                return 'Viernes' ;
            case 6:
                return 'Sabado' ;
            case 7:
                return 'Domingo' ;
        }
    }
}
