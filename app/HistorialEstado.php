<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class HistorialEstado extends Model
{
    public function reclamo(){
        return $this->belongsTo(Reclamo::class);
    }
    public function estado(){
        return $this->belongsTo(Estado::class);
    }

    public function getFechaHora(){
        $transformacion = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at);
        return $transformacion->format('d/m/Y H:i:s');

    }
}
