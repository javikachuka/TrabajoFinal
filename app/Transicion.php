<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transicion extends Model
{
    public function flujoTrabajo()
    {
        return $this->belongsTo(FlujoTrabajo::class);
    }


}
