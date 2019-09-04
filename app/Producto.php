<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $guarded = [] ;

    public function categoria(){
        return $this->belongsTo(Categoria::class) ;
    }
}
