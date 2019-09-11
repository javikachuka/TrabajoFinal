<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CabeceraMovimiento extends Model
{
    protected $guarded = [] ;

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function tipoComprobante(){
        return $this->belongsTo(TipoComprobante::class, 'tipoComprobante_id');
    }
}
