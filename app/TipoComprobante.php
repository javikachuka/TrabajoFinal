<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoComprobante extends Model
{
    use SoftDeletes;
    protected $guarded = [] ;

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function cabecerasMovimiento(){
        return $this->hasMany(CabeceraMovimiento::class, 'tipoComprobante_id');
    }
}
