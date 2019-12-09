<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use SoftDeletes ;

    protected $table = "proveedores" ;

    protected $fillable  = ['nombre', 'cuit' , 'email' , 'telefono'] ;

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function cabecerasMovimiento()
    {
        return $this->hasMany(CabeceraMovimiento::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }

    public function pedidos(){
        return $this->hasMany(Pedido::class);
    }



}
