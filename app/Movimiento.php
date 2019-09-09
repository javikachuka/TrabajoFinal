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

    public function tiposMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class,'tipo_movimiento_id');
    }

    public function cabeceraMovimiento()
    {
        return $this->belongsTo(CabeceraMovimiento::class,'cabecera_movimiento_id');
    }

}
