<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Producto extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $guarded = [];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function setCodigoAttribute($value)
    {
        $this->attributes['codigo'] = strtoupper($value);
    }



    public function rubro()
    {
        return $this->belongsTo(Rubro::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    public function existencias()
    {
        return $this->hasMany(Existencia::class);
    }

    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class);
    }

    public function medida()
    {
        return $this->belongsTo(Medida::class);
    }

    public function detalles(){
        return $this->hasMany(Detalle::class);
    }


    public function cantidadTotal()
    {
        $exis = $this->existencias;
        $can = 0;
        foreach ($exis as $e) {
            $can += $e->cantidad;
        }

        return $can;
    }

    public function cantidadAlmacen($almacen_id)
    {
        $exis = $this->existencias;
        foreach ($exis as $e) {
            if ($e->almacen_id == $almacen_id) {
                return $e->cantidad;
            }
        }
    }

    public function isCantidadMinima($cantidad){
        if(($this->cantidadTotal()-$cantidad) <= $this->cantidadMinima){
            return true ;
        } else {
            return false ;
        }
    }

    public function estaEnCantidadMinima(){
        if($this->cantidadTotal() <= $this->cantidadMinima){
            return true;
        }else{
            return false ;
        }
    }

    public function getCantidadEgreso(Almacen $a){
        $cant = 0 ;
        foreach($a->movimientosOrigen as $m){
            if($m->producto->id == $this->id){
                $cant += $m->cantidad ;
            }
        }
        return $cant ;
    }

    public function cantidadUtilizada(Almacen $almacen){
        $cantidad = 0 ;
        foreach($almacen->movimientosOrigen as $mov){
            if($mov->producto->id == $this->id){
                if($mov->tipoMovimiento->operacion === 0){
                    $cantidad += $mov->cantidad ;
                }
            }
        }
        return $cantidad ;

    }

}
