<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CabeceraMovimiento extends Model
{
    protected $guarded = [] ;

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class)->withTrashed();
    }

    public function trabajo()
    {
        return $this->belongsTo(Trabajo::class)->withTrashed();
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function tipoComprobante(){
        return $this->belongsTo(TipoComprobante::class, 'tipoComprobante_id');
    }

    public function getFechaComprobante(){
        $date = Carbon::create($this->fechaComprobante)->format('d/m/Y') ;
        return $date  ;
    }

    public function getFechaMovimiento(){
        $date = Carbon::create($this->fecha)->format('d/m/Y') ;
        return $date  ;
    }
}
