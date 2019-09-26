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
            'nombre'          => 'En espera',
        ]);

        Estado::create([
            'nombre'          => 'Recibido',
        ]);

        Estado::create([
            'nombre'          => 'Iniciado',
        ]);

        Estado::create([
            'nombre'          => 'Revisado',
        ]);

        Estado::create([
            'nombre'          => 'Terminado',
        ]);

        Estado::create([
            'nombre'          => 'Cancelado',
        ]);


        FlujoTrabajo::create([
            'nombre'          => 'Trabajos' ,
        ]);

        FlujoTrabajo::create([
            'nombre'          => 'Quejas' ,
        ]);

    }
}
