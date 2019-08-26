<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    public function barrio(){
        return $this->belongsTo(Barrio::class) ;
    }

    public function socios(){
        return $this->hasMany(Socio::class) ;
    }

}
