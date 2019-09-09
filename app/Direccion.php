<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones' ;

    protected $fillable = [
        'zona_id' ,
        'calle' ,
        'altura'
     ] ;

    public function zona(){
        return $this->belongsTo(Zona::class) ;
    }

    public function socios(){
        return $this->hasMany(Socio::class) ;
    }

    public function users(){
        return $this->hasMany(User::class) ;
    }

    public function direccion()
    {
        return $this->belongsTo(Almacen::class);
    }
}
