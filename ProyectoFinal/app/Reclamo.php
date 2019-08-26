<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reclamo extends Model
{

	public function tipoReclamos(){
		return $this->hasMany(TipoReclamo::class);
	}

	public function documentaciones(){
		return $this->belongsToMany(Documentacion::class) ;
	}

    public function setNombreAttribute($value){
    	$this->attributes['nombre'] = strtoupper($value) ;
    }

    public function setDescripcionAttribute($value){
    	$this->attributes['descripcion'] = strtolower($value) ;
	}
}
