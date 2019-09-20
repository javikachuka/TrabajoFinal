<?php

use App\Prioridad;
use App\TipoReclamo;
use Illuminate\Database\Seeder;

class PrioridadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //creacion de prioridades
        Prioridad::create([
            'nivel' => 1 ,
            'nombre' => 'Bajo',
        ]) ;
        Prioridad::create([
            'nivel' => 2 ,
            'nombre' => 'Medio',
        ]) ;
        Prioridad::create([
            'nivel' => 3 ,
            'nombre' => 'Intermedio',
        ]) ;
        Prioridad::create([
            'nivel' => 4 ,
            'nombre' => 'Alto',
        ]) ;
        Prioridad::create([
            'nivel' => 5 ,
            'nombre' => 'Urgente',
        ]) ;

        //creacion de Tipos de reclamos
        TipoReclamo::create([
            'nombre' => 'Ruptura Caño PVC' ,
            'trabajo' => 1 ,
            'prioridad_id' => 4 ,
        ]) ;
        TipoReclamo::create([
            'nombre' => 'Cambio de Medidor' ,
            'trabajo' => 1 ,
            'prioridad_id' => 3 ,
        ]) ;
        TipoReclamo::create([
            'nombre' => 'Perdida de Manguera' ,
            'trabajo' => 1 ,
            'prioridad_id' => 2 ,
        ]) ;
        TipoReclamo::create([
            'nombre' => 'Quejas del Socio' ,
            'trabajo' => 0 ,
            'prioridad_id' => 1 ,
        ]) ;
        TipoReclamo::create([
            'nombre' => 'Ruptura de Caño Principal' ,
            'trabajo' => 1 ,
            'prioridad_id' => 5 ,
        ]) ;
    }
}
