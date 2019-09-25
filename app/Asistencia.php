<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    public function usuario(){
        return $this->belongsTo(User::class);
    }
}
