<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rubro extends Model
{
    use SoftDeletes ;

    protected $guarded = [] ;

    public function productos(){
        return $this->hasMany(Producto::class) ;
    }
}
