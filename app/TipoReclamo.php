<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoReclamo extends Model
{
    public function reclamos(){
        return $this->hasMany(Reclamo::class);
    }

    public function prioridad(){
        return $this->belongsTo(Prioridad::class);
    }

    public function flujoTrabajo(){
        return $this->belongsTo(FlujoTrabajo::class , 'flujoTrabajo_id');
    }

    public function requisitos(){
        return $this->belongsToMany(Requisito::class);
    }
}
