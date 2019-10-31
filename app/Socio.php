<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Socio extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'apellido',
        'nombre',
        'dni',
    ];

    public function direcciones()
    {
        return $this->hasMany(Direccion::class);
    }


    // public function getNombreAttribute($value)
    // {
    //     return ucwords($value);
    // }

    // public function getApellidoAttribute($value)
    // {
    //     return ucwords($value);
    // }

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = ucwords($value);
    }

    public function setApellidoAttribute($value)
    {
        $this->attributes['apellido'] = ucwords($value);
    }

    // public function getRouteKeyName()
    // {
    //     return 'apellido';
    // }

    // public function scopeDescrip($query){
    //     return 'hola' ;
    // }

    public function getIdDireccion($nro_conexion){
        foreach($this->direcciones as $d){
            if($d->nro_conexion == $nro_conexion){
                return $d->id;
            }
        }
    }
}
