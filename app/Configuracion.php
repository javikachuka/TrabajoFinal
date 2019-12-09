<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuraciones' ;

    protected $guarded = ['logo'] ;

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }


}
