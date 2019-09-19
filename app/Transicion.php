<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transicion extends Model
{
    public function flujoTrabajo()
    {
        return $this->belongsTo(FlujoTrabajo::class , 'flujoTrabajo_id');
    }

    public function estadoInicial(){
        return $this->belongsTo(Estado::class, 'estadoInicial_id');
    }

    public function estadoFinal(){
        return $this->belongsTo(Estado::class, 'estadoFinal_id');
    }

    public function asignarEstadoInicial($estado){

        $this->estadoInicial_id = $estado;
        return true ;
    }

    public function asignarEstadoFinal($estado){
        if($this->estadoInicial_id != $estado){
            $this->estadoFinal_id = $estado ;
            return true ;
        }
        return false ;
    }

}
