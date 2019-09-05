<?php

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
    }
}
