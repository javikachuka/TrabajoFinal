<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlujoTrabajo extends Model
{
    protected $guarded = [];

    public function transiciones()
    {
        return $this->hasMany(Transicion::class, 'flujoTrabajo_id');
    }

    public function tipoReclamo()
    {
        return $this->hasOne(TipoReclamo::class, 'flujoTrabajo_id');
    }

    public function getEstadoInicial()
    {
        return $this->transiciones[0]->estadoInicial->id;
    }

    public function getEstados()
    {
        $estados = collect();

        foreach ($this->transiciones as $transicion) {
            $estado = $transicion->estadoInicial;
            if (!$estados->contains($estado)) {
                $estados->push($estado);
            }
            $estado = $transicion->estadoFinal;
            if (!$estados->contains($estado)) {
                $estados->push($estado);
            }
        }

        return $estados;
    }

    public function siguienteEstado(Estado $estado)
    {
        $transiciones = $this->transiciones;
        foreach ($transiciones as  $transicion) {
            if ($transicion->estadoInicial == $estado) {
                return $transicion->estadoFinal;
            }
        }
    }


    public function getPosiblesEstados(Estado $estado)
    {
        $transiciones = $this->transiciones;
        $estados = collect();
        foreach ($transiciones as $key => $transicion) {
            if ($transicion->estadoInicial == $estado) {
                $estados->push($transicion->estadoFinal);
            }
        }
        return $estados;
    }

    //obtiene el estado final del flujo
    public function getEstadoFinal()
    {
        $transiciones = $this->transiciones;
        $transicionesFiltadras = $transiciones;
        $disponible = true;
        foreach ($transicionesFiltadras as $t1 => $tran1) {
            foreach ($transiciones as $t2 => $tran2) {

                if ($tran1->estadoFinal == $tran2->estadoInicial) {
                    $disponible = false;
                }
            }
            if ($disponible == true) {
                return $tran1->estadoFinal;
            }
            $disponible = true;
        }
    }

    // public function siguienteEstado(Reclamo $reclamo){
    //     $this->transiciones($reclamo);
    // }

}
