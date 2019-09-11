<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Proveedor ;
use Faker\Generator as Faker;

$factory->define(Proveedor::class, function (Faker $faker) {
    return [
        'nombre' => $faker->lastName,
        'cuit' => $faker->randomNumber($nbDigits = 8),
        'email' => $faker->unique()->safeEmail,
        'telefono' => $faker->randomNumber($nbDigits = 8),

    ];
});
