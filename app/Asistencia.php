<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Asistencia extends Model
{
    public function empleado(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDia(){
        $date = Carbon::create($this->dia)->format('d/m/Y') ;
        return $date  ;
    }

}
