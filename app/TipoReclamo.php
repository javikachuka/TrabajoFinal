<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoReclamo extends Model
{

    use SoftDeletes ;

    protected $guarded = [] ;

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
