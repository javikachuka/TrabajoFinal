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
            'nombre'          => 'Neto',
            'simbolo'         => 'N'
        ]);

        Medida::create([
            'nombre'          => 'kilogramo',
            'simbolo'         => 'Kg',
        ]);
        Medida::create([
            'nombre'          => 'Gramo',
            'simbolo'         => 'g' ,
        ]);
        Medida::create([
            'nombre'          => 'Litro',
            'simbolo'         => 'L' ,
        ]);

    }
}
