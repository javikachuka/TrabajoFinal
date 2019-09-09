<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transicion extends Model
{
    public function flujoTrabajo()
    {
        return $this->belongsTo(FlujoTrabajo::class);
    }

    public function estadoInicial(){
        return $this->hasOne(Estado::class);
    }

    public function estadoFinal(){
        return $this->hasOne(Estado::class);
    }

    public function asignarEstadoInicial($estado){

        $this->estadoInicial = $estado;
        return true ;
    }

    public function asignarEstadoFinal($estado){
        if($this->estadoInicial != $estado){
            $this->estadoFinal = $estado ;
            return true ;
        }
        return false ;
    }

}
