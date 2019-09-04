<?php

use App\Categoria;
use Illuminate\Database\Seeder;

class CategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nombre'          => 'CAÑOS',
        ]);

        Categoria::create([
            'nombre'          => 'MANGUERAS',
        ]);

        Categoria::create([
            'nombre'          => 'MEDIDORES',
        ]);
    }
}
