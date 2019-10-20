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
}
