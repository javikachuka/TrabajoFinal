<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    public function estado(){
        return $this->belongsTo(Estado::class);
    }

    public function reclamo(){
        return $this->hasOne(Reclamo::class);
    }

    public function socio(){
        return $this->belongsTo(Socio::class);
    }
}
