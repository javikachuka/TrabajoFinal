<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{

    protected $fillable = [
       'barrio_id' ,
       'calle' ,
       'altura' 
    ] ;

    public function barrio(){
        return $this->belongsTo(Barrio::class) ;
    }

    public function socios(){
        return $this->hasMany(Socio::class) ;
    }

    public function users(){
        return $this->hasMany(User::class) ;
    }

}
