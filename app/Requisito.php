<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisito extends Model
{
    public function controles(){
        return $this->hasMany(Control::class);
    }

    public function tipoReclamos(){
        return $this->belongsToMany(TipoReclamo::class);
    }

}
