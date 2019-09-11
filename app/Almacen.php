<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = 'almacenes' ;

    public function direccion()
    {
        return $this->hasOne(Direccion::class);
    }

    public function cabecerasMovimiento()
    {
        return $this->hasMany(CabeceraMovimiento::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }

    public function movimientosOrigen()
    {
        return $this->hasMany(Movimiento::class,'almacenOrigen_id');
    }

    public function movimientosDestino()
    {
        return $this->hasMany(Movimiento::class,'almacenDestino_id');
    }

}
