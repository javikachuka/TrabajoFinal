<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlujoTrabajo extends Model
{
    protected $guarded = [] ;

    public function transiciones(){
        return $this->hasMany(Transicion::class , 'flujoTrabajo_id') ;
    }

    public function tipoReclamo(){
        return $this->hasOne(TipoReclamo::class , 'flujoTrabajo_id');
    }

    public function getEstadoInicial(){
        return $this->transiciones[0]->estadoInicial->id ;
    }

    // public function siguienteEstado(Reclamo $reclamo){
    //     $this->transiciones($reclamo);
    // }

}
