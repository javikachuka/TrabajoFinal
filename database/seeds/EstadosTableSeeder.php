<?php

use App\Estado;
use App\FlujoTrabajo;
use Illuminate\Database\Seeder;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estado::create([
            'nombre'          => 'iniciado',
        ]);

        Estado::create([
            'nombre'          => 'revisado',
        ]);

        Estado::create([
            'nombre'          => 'terminado',
        ]);


        FlujoTrabajo::create([
            'nombre'          => 'Pepepee' ,
        ]);

        FlujoTrabajo::create([
            'nombre'          => 'Rolando' ,
        ]);

    }
}
