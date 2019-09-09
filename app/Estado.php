<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public function tranInicial(){
        return $this->belongsTo(Transicion::class , 'estadoInicial');
    }

    public function tranFinal(){
        return $this->belongsTo(Transicion::class , 'estadoFinal');
    }


}
