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

    public function getEstados(){
        $estados = collect() ;

        foreach ($this->transiciones as $transicion){
            $estado = $transicion->estadoInicial ;
            if(!$estados->contains($estado)){
                $estados->push($estado) ;
            }
            $estado = $transicion->estadoFinal ;
            if(!$estados->contains($estado)){
                $estados->push($estado) ;
            }
        }

        return $estados ;
    }

    public function siguienteEstado(Estado $estado){
        $transiciones = $this->transiciones;
        foreach ($transiciones as  $transicion) {
            if($transicion->estadoInicial == $estado){
                return $transicion->estadoFinal;
            }
        }
    }

    // public function siguienteEstado(Reclamo $reclamo){
    //     $this->transiciones($reclamo);
    // }

}
