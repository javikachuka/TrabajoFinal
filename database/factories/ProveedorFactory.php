<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Proveedor ;
use Faker\Generator as Faker;

$factory->define(Proveedor::class, function (Faker $faker) {
    return [
        'nombre' => $faker->sentence,
        'cuit' => $faker->sentence,
        'email' => $faker->unique()->safeEmail,
        'telefono' => $faker->randomNumber($nbDigits = 8),

    ];
});
