<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function horario(){
        return $this->belongsTo(Horario::class);
    }

}
