<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    

    public function domicilios(){
        return $this->hasMany(Domicilio::class) ;
    }
}
