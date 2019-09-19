<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    protected $table = "controles" ;

    public function reclamos(){
        return $this->belongsTo(Reclamo::class);
    }

    public function requisitos(){
        return $this->belongsTo(Requisito::class);
    }
}
