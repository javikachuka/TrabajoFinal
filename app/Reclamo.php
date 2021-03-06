<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

class Reclamo extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    use SoftDeletes ;
    protected $guarded = [] ;

	public function tipoReclamo(){
		return $this->belongsTo(TipoReclamo::class, 'tipoReclamo_id')->withTrashed();
	}

	public function controles(){
		return $this->hasMany(Control::class) ;
    }

    public function trabajo(){
        return $this->belongsTo(Trabajo::class);
    }

    public function direccion(){
        return $this->belongsTo(Direccion::class,  'direccion_id');
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

    public function presentoRequisito(Requisito $req){
        foreach($this->controles as $con){
            if($con->requisito_id == $req->id){
                return true ;
            }
        }
        return false ;
    }

    public function getFecha(){
        $date = Carbon::create($this->fecha)->format('d/m/Y') ;
        return $date  ;
    }


    public function getCantidadEstados(){
        return sizeof($this->historial);
    }
}
