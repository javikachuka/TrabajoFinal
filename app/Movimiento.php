<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Movimiento extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    Use SoftDeletes ;

    protected $guarded = [ 'tipo_movimiento_id' ] ;

    public function producto()
    {
        return $this->belongsTo(Producto::class );
    }

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class,'tipo_movimiento_id');
    }

    public function cabeceraMovimiento()
    {
        return $this->belongsTo(CabeceraMovimiento::class,'cabecera_movimiento_id');
    }

    public function almacenOrigen()
    {
        return $this->belongsTo(Almacen::class,'almacenOrigen_id')->withTrashed();
    }

    public function almacenDestino()
    {
        return $this->belongsTo(Almacen::class,'almacenDestino_id')->withTrashed();
    }


    public function getFecha(){

        return $this->cabeceraMovimiento->fecha;
    }
}
