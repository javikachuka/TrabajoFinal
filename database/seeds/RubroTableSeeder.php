<?php

use App\Medida;
use App\Rubro;
use Illuminate\Database\Seeder;

class RubroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rubro::create([
            'nombre'          => 'CAÑOS',
        ]);

        Rubro::create([
            'nombre'          => 'MANGUERAS',
        ]);

        Rubro::create([
            'nombre'          => 'MEDIDORES',
        ]);

        Rubro::create([
            'nombre'          => 'CODOS',
        ]);

        Rubro::create([
            'nombre'          => 'LLAVES',
        ]);

        //creacion de medidas

        Medida::create([
            'nombre'          => 'Metro/s',
            'simbolo'         => 'M'
        ]);

        Medida::create([
            'nombre'          => 'Unidad/es',
            'simbolo'         => 'U'
        ]);

        Medida::create([
            'nombre'          => 'Centimetro/s',
            'simbolo'         => 'cm'
        ]);

        Medida::create([
            'nombre'          => 'Kilogramo/s',
            'simbolo'         => 'Kg',
        ]);
        Medida::create([
            'nombre'          => 'Gramo/s',
            'simbolo'         => 'g' ,
        ]);

        Medida::create([
            'nombre'          => 'Litro/s',
            'simbolo'         => 'L' ,
        ]);

        Medida::create([
            'nombre'          => 'Mililitros/s',
            'simbolo'         => 'ml' ,
        ]);

    }
}
