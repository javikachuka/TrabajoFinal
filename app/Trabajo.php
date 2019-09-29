<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Trabajo extends Model
{
    use SoftDeletes ;

    public function estado(){
        return $this->belongsTo(Estado::class);
    }

    public function reclamo(){
        return $this->hasOne(Reclamo::class);
    }

    public function socio(){
        return $this->belongsTo(Socio::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function getFecha(){
        $date = Carbon::create($this->fecha)->format('d/m/Y') ;
        return $date  ;
    }

}
