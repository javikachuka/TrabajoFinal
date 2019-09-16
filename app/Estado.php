<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{

    protected $guarded = [] ;

    public function tranInicial(){
        return $this->hasMany(Transicion::class , 'estadoInicial_id');
    }

    public function tranFinal(){
        return $this->hasMany(Transicion::class , 'estadoFinal_id');
    }

    public function trabajo(){
        return $this->hasOne(Trabajo::class);
    }

    public function historial(){
        return $this->hasMany(HistorialEstado::class);
    }

}
