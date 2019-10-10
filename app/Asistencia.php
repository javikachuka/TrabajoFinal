<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Asistencia extends Model
{
    public function empleado(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDia(){
        $date = Carbon::create($this->dia)->format('d/m/Y') ;
        return $date  ;
    }

    public function getNombreDia(){
        $date = Carbon::create($this->dia) ;
        switch($date->dayOfWeek){
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
