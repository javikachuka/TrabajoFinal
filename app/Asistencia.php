<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Asistencia extends Model
{
    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function getDia(){
        $date = Carbon::create($this->dia)->format('d/m/Y') ;
        return $date  ;
    }

}
