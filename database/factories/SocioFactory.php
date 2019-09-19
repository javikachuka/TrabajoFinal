<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Socio;
use Faker\Generator as Faker;

$factory->define(Socio::class, function (Faker $faker) {
    return [
        'apellido' => $faker->lastName,
        'nombre' => $faker->name,
        'dni' => $faker->randomNumber($nbDigits = 8),
        'nro_conexion' => $faker->randomNumber($nbDigits = 8),
        'direccion_id' => 1,
    ];
});
