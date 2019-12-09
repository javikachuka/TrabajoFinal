<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requisito extends Model
{
    use SoftDeletes ;

    protected $guarded = [] ;

    public function controles(){
        return $this->hasMany(Control::class);
    }

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function tipoReclamos(){
        return $this->belongsToMany(TipoReclamo::class);
    }

}
