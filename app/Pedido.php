<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Pedido extends Model
{
    use SoftDeletes;

    public function detalles(){
        return $this->hasMany(Detalle::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class)->withTrashed();
    }

    public function getFecha(){
        $date = Carbon::create($this->fecha)->format('d/m/Y') ;
        return $date  ;
    }

    public function siguienteId(){
        $pedidos = Pedido::all() ;
        if(!$pedidos->isEmpty()){
            return $pedidos->last()->id ;
        }else{
            return 1 ;
        }
    }
}
