<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    public function domicilio(){
        return $this->belongsTo(Domicilio::class) ;
    }

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

    public function getRouteKeyName(){
        return 'apellido';
    }

    // public function scopeDescrip($query){
    //     return 'hola' ;
    // }
}
