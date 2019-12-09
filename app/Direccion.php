<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Direccion extends Model
{
    use SoftDeletes ;
    protected $table = 'direcciones';

    protected $fillable = [
        'zona_id',
        'calle',
        'altura'
    ];

    public function setCalleAttribute($value)
    {
        $this->attributes['calle'] = ucwords($value);
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function socio()
    {
        return $this->belongsTo(Socio::class)->withTrashed();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function almacen()
    {
        return $this->hasOne(Almacen::class);
    }

    public function reclamos()
    {
        return $this->hasMany(Reclamo::class);
    }


}
