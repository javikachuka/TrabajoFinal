<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{

    protected $guarded = [] ;

    public function rubro(){
        return $this->belongsTo(Rubro::class) ;
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


    public function cantidadTotal(){
        $exis = $this->existencias;
        $can = 0;
        foreach($exis as $e){
            $can += $e->cantidad ;
        }

        return $can ;
    }

    public function cantidadAlmacen($almacen_id){
        $exis = $this->existencias;
        foreach($exis as $e){
            if($e->almacen_id == $almacen_id){
                return $e->cantidad ;
            }
        }
    }
}
