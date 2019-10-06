<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Socio extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'apellido' ,
        'nombre' ,
        'dni' ,
        'nro_conexion'] ;

    public function direccion(){
        return $this->belongsTo(Direccion::class) ;
    }

    public function reclamos(){
        return $this->hasMany(Reclamo::class);
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
