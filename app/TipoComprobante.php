<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    public function cabecerasMovimiento(){
        return $this->hasMany(CabeceraMovimiento::class, 'tipoComprobante_id');
    }
}
