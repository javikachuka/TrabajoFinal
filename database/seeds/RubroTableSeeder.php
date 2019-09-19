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

        //creacion de medidas

        Medida::create([
            'nombre'          => 'Metros',
            'simbolo'         => 'M'
        ]);

        Medida::create([
            'nombre'          => 'Unidades',
            'simbolo'         => 'P/U'
        ]);

        Medida::create([
            'nombre'          => 'Kilogramos',
            'simbolo'         => 'Kg',
        ]);
        Medida::create([
            'nombre'          => 'Gramos',
            'simbolo'         => 'g' ,
        ]);
        Medida::create([
            'nombre'          => 'Litros',
            'simbolo'         => 'L' ,
        ]);

    }
}
