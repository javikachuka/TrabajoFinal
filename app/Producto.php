<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $guarded = [] ;

    public function rubro(){
        return $this->belongsTo(Rubro::class) ;
    }

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class);
    }

    public function almacenes()
    {
        return $this->belongsToMany(Almacen::class);
    }

    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class);
    }

    public function sumarCantidad($cantidad){
        $this->cantidad += $cantidad;
    }

    public function restarCantidad($cantidad){
        if($cantidad <= $this->cantidad){
            $this->cantidad -= $cantidad;
        }

    }
}
