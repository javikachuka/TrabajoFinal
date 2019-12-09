<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use SoftDeletes;

    protected $guarded = [] ;

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function tranInicial(){
        return $this->hasMany(Transicion::class , 'estadoInicial_id');
    }

    public function tranFinal(){
        return $this->hasMany(Transicion::class , 'estadoFinal_id');
    }

    public function trabajo(){
        return $this->hasOne(Trabajo::class);
    }

    public function historial(){
        return $this->hasMany(HistorialEstado::class);
    }

    public function isUltimo($id){
        $flujo = FlujoTrabajo::find($id) ;
        if($this->id == $flujo->getEstadoFinal()->id){
            return true ;
        }
        return false ;
    }

}
