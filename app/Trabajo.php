<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Trabajo extends Model
{
    use SoftDeletes ;

    public function estado(){
        return $this->belongsTo(Estado::class);
    }

    public function reclamo(){
        return $this->hasOne(Reclamo::class);
    }

    public function socio(){
        return $this->belongsTo(Socio::class);
    }

    public function cabecerasMovimientos(){
        return $this->hasMany(CabeceraMovimiento::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function getFecha(){
        $date = Carbon::create($this->fecha)->format('d/m/Y') ;
        return $date  ;
    }

    public function diferencia(){
        $inicio = Carbon::create($this->horaInicio) ;
        return $inicio->diffForHumans() ;
    }


    public function ultimoEstado(){
        return $this->updated_at->diffForHumans() ;
    }

    public function tiempoDuracion(){
        $inicio = Carbon::create($this->horaInicio) ;
        $fin = Carbon::create($this->horaFin) ;
        $resul = round($inicio->diffInMinutes($fin)/60, 2) ;
        return  str_replace('.', ':' , $resul ) ;

    }

    public function tiempoDuracionEstimado($tipoTrabajo){
        $trabajos = Trabajo::all();
        $suma = 0 ;
        $div = 0;
        foreach($trabajos as $trabajo){
            if($trabajo->reclamo->tipoReclamo->id == $tipoTrabajo){
                if($trabajo->horaFin != null){
                    $inicio = Carbon::create($trabajo->horaInicio) ;
                    $fin = Carbon::create($trabajo->horaFin) ;
                    $suma += $inicio->diffInMinutes($fin)/60 ;
                    $div += 1 ;
                }
            }
        }
        if($div != 0){
            $resul = $suma/$div ;
            $enHoras = round($resul, 2) ;
            return str_replace('.', ':' , $enHoras ) ;
        }else{
            return 0 ;
        }
    }

    public function recomendaciones(){

        $trabajos = Trabajo::all();
        $productos = collect() ;
        foreach($trabajos as $trabajo){
            if($trabajo->reclamo->tipoReclamo_id == $this->reclamo->tipoReclamo_id){
                if($trabajo->estado == $trabajo->reclamo->tipoReclamo->flujoTrabajo->getEstadoFinal()){
                    foreach($trabajo->cabecerasMovimientos[0]->movimientos as $mov){
                        if($mov->tipoMovimiento->operacion == false){
                            if(!$productos->contains('id', $mov->producto->id)){
                                $productos->add($mov->producto) ;
                            }
                        }
                    }
                }
            }
        }
        return $productos ;
    }

    public function recomendacionCantidad(Producto $producto){
        $cantidad = 0;
        $div = 0 ;
        foreach($producto->movimientos as $mov){
            if($mov->tipoMovimiento->operacion == false){
                $cantidad += $mov->cantidad ;
                $div += 1;
            }
        }

        if($div != 0){
            $promedio = $cantidad/$div ;
            return ceil($promedio) ;
        }else{
            return 0;
        }
    }

}
