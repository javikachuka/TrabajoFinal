<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Existencia extends Model
{

    public function setAlmacen($id){
        $this->almacen_id = $id;
    }

    public function setProducto($id){
        $this->producto_id = $id;
    }

    public function setCantidad($cant){
        $this->cantidad = $cant;
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
