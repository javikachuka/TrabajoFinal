<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    public function pedido(){
        return $this->belongsTo(Pedido::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
