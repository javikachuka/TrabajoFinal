<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoReclamo extends Model
{

    use SoftDeletes ;

    protected $guarded = [] ;

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function reclamos(){
        return $this->hasMany(Reclamo::class, 'tipoReclamo_id');
    }

    public function prioridad(){
        return $this->belongsTo(Prioridad::class);
    }

    public function flujoTrabajo(){
        return $this->belongsTo(FlujoTrabajo::class , 'flujoTrabajo_id');
    }

    public function requisitos(){
        return $this->belongsToMany(Requisito::class);
    }

    public function tieneRequisitos(){
        if(empty($this->requisitos[0])){
            return false ;
        }else{
            return true;
        }
    }

    public function getDuracionRealAttribute(){
        if(!$this->reclamos->isEmpty()){
            return $this->reclamos->first()->trabajo->duracionEstimadaReal($this->id);
        }else{
            return 0 ;
        }
    }

    public function getFrecuenciaAttribute(){
        return Reclamo::where('tipoReclamo_id', $this->id)->get()->count() ;
    }
}
