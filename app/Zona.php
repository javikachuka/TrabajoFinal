<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Zona extends Model
{
    protected $guarded = [] ;

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = ucwords($value);
    }

    public function direcciones(){
        return $this->hasMany(Direccion::class) ;
    }

    public function getCantidadReclamosAttribute(){
        $cantidad = DB::table('zonas')
                ->join('direcciones', 'zonas.id', '=', 'direcciones.zona_id')
                ->join('reclamos', 'direcciones.id', '=', 'reclamos.direccion_id')
                ->select('zonas.*', 'reclamos.tipoReclamo_id')->where('zonas.id', $this->id)->get()->count();
        return $cantidad;
    }
}
