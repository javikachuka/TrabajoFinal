<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prioridad extends Model
{
    protected $table = 'prioridades' ;

    public function tipoReclamos(){
        return $this->hasMany(TipoReclamo::class);
    }
}
