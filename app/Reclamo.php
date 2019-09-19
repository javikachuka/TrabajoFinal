<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reclamo extends Model
{

    protected $guarded = [] ;

	public function tipoReclamo(){
		return $this->belongsTo(TipoReclamo::class, 'tipoReclamo_id');
	}

	public function controles(){
		return $this->hasMany(Control::class) ;
    }

    public function trabajo(){
        return $this->belongsTo(Trabajo::class);
    }

    public function socio(){
        return $this->belongsTo(Socio::class);
    }

    public function usuario(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public function historial(){
        return $this->hasMany(HistorialEstado::class);
    }


    public function setNombreAttribute($value){
    	$this->attributes['nombre'] = strtoupper($value) ;
    }

    public function setDescripcionAttribute($value){
    	$this->attributes['descripcion'] = strtolower($value) ;
	}
}
