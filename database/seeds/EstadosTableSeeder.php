<?php

use App\Estado;
use App\FlujoTrabajo;
use App\Transicion;
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
            'nombre'          => 'Recibido',
        ]);


        Estado::create([
            'nombre'          => 'En espera',
        ]);

        Estado::create([
            'nombre'          => 'Iniciado',
        ]);

        Estado::create([
            'nombre'          => 'Falta',
        ]);

        Estado::create([
            'nombre'          => 'Terminado',
        ]);

        Estado::create([
            'nombre'          => 'Cancelado',
        ]);

        Estado::create([
            'nombre'          => 'Sin Existencias',
        ]);


        FlujoTrabajo::create([
            'nombre'          => 'Trabajos' ,
        ]);

        FlujoTrabajo::create([
            'nombre'          => 'Quejas' ,
        ]);


        Transicion::create([
            'nombre' => 'Reclamo En Condiciones',
            'orden' => 1,
            'flujoTrabajo_id' => 1,
            'estadoInicial_id' => 1,
            'estadoFinal_id' => 2,
        ]) ;

        Transicion::create([
            'nombre' => 'Reclamo Con Faltantes',
            'orden' => 2,
            'flujoTrabajo_id' => 1,
            'estadoInicial_id' => 1,
            'estadoFinal_id' => 4,
        ]) ;

        Transicion::create([
            'nombre' => 'Reclamo - Trabajo En Reparacion',
            'orden' => 3,
            'flujoTrabajo_id' => 1,
            'estadoInicial_id' => 2,
            'estadoFinal_id' => 3,
        ]) ;

        Transicion::create([
            'nombre' => 'Fin Del Reclamo - Trabajo',
            'orden' => 4,
            'flujoTrabajo_id' => 1,
            'estadoInicial_id' => 3,
            'estadoFinal_id' => 5,
        ]) ;

        Transicion::create([
            'nombre' => 'Reclamo Con Faltantes A En Condiciones',
            'orden' => 5,
            'flujoTrabajo_id' => 1,
            'estadoInicial_id' => 4,
            'estadoFinal_id' => 2,
        ]) ;

        Transicion::create([
            'nombre' => 'Faltante De Productos Para Llevar A Cabo El Trabajo',
            'orden' => 6,
            'flujoTrabajo_id' => 1,
            'estadoInicial_id' => 1,
            'estadoFinal_id' => 7,
        ]) ;

        Transicion::create([
            'nombre' => 'Ingreso De Insumos',
            'orden' => 7,
            'flujoTrabajo_id' => 1,
            'estadoInicial_id' => 7,
            'estadoFinal_id' => 2,
        ]) ;

    }
}
