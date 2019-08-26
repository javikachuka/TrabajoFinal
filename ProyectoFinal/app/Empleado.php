<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{


    public function getNombreAttribute($value){
    	return ucwords($value) ;
    }

    public function getApellidoAttribute($value){
    	return ucwords($value) ;
    }

    public function setNombreAttribute($value){
    	$this->attributes['nombre'] = ucwords($value) ;
    }

    public function setApellidoAttribute($value){
    	$this->attributes['apellido'] = ucwords($value) ;
    }
}
