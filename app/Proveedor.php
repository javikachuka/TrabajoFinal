<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = "proveedores" ;

    protected $guarded = [] ;

    public function cabecerasMovimiento()
    {
        return $this->hasMany(CabeceraMovimiento::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }

}
