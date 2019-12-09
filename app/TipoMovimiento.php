<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{

    protected $guarded = [] ;

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
