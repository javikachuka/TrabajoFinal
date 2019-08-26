<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoReclamo extends Model
{
    public function reclamo(){
        return $this->belongsTo(Reclamo::class);
    }
}
