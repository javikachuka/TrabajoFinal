<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $guarded = [] ;

    public function rubro(){
        return $this->belongsTo(Rubro::class) ;
    }
}
