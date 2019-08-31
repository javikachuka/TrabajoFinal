<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documentacion extends Model
{

    protected $table = 'documentaciones' ;

    public function reclamos(){
    	return $this->belongsToMany(Reclamo::class) ;
    }

    public function getNombreAttribute($value){
    	return strtoupper($value) ;
    }

    public function setNombreAttribute($value){
    	$this->attributes['nombre'] = strtoupper($value) ;
    }
}
