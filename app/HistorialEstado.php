<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialEstado extends Model
{
    public function reclamo(){
        return $this->belongsTo(Reclamo::class);
    }
    public function estado(){
        return $this->belongsTo(Estado::class);
    }
}
