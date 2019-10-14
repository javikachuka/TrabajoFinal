<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $guarded = [] ;

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = ucwords($value);
    }

    public function domicilios(){
        return $this->hasMany(Domicilio::class) ;
    }
}
