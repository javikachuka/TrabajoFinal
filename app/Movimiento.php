<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{

    protected $guarded = [ 'tipo_movimiento_id' ] ;

    public function producto()
    {
        return $this->hasOne(Producto::class);
    }

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class,'tipo_movimiento_id');
    }

    public function cabeceraMovimiento()
    {
        return $this->belongsTo(CabeceraMovimiento::class,'cabecera_movimiento_id');
    }

    public function almacenOrigen()
    {
        return $this->belongsTo(Almacen::class,'almacenOrigen_id');
    }

    public function almacenDestino()
    {
        return $this->belongsTo(Almacen::class,'almacenDestino_id');
    }


}
