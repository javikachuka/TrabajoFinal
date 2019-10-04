<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Almacen extends Model
{
    use SoftDeletes ;
    protected $table = 'almacenes' ;

    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }

    public function cabecerasMovimiento()
    {
        return $this->hasMany(CabeceraMovimiento::class);
    }

    public function existencias()
    {
        return $this->hasMany(Existencia::class);
    }

    public function movimientosOrigen()
    {
        return $this->hasMany(Movimiento::class,'almacenOrigen_id');
    }

    public function movimientosDestino()
    {
        return $this->hasMany(Movimiento::class,'almacenDestino_id');
    }

    public function existeProducto($prod_id){
        $exis = $this->existencias;

        foreach($exis as $e){
            if($e->producto->id == $prod_id){
                return true ;
            }
        }
        return false ;
    }

    public function sumarExistencia($prod_id , $cant){
        $exis = $this->existencias;

        foreach($exis as $e){
            if($e->producto->id == $prod_id){
                $e->cantidad += $cant ;
                $e->update() ;
                return true ;
            }
        }

        return false ;
    }

    public function restarExistencia($prod_id , $cant){
        $exis = $this->existencias;

        foreach($exis as $e){
            if($e->producto->id == $prod_id){
                $e->cantidad -= $cant ;
                $e->update() ;
                return true ;
            }
        }

        return false ;
    }

    public function getCantidadProd($prod_id){
        $exis = $this->existencias;

        foreach($exis as $e){
            if($e->producto_id == $prod_id){
                return $e->cantidad ;
            }
        }
    }

}
