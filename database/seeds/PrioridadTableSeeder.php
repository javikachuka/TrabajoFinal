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
            'nombre' => 'BAJO',
        ]) ;
        Prioridad::create([
            'nivel' => 2 ,
            'nombre' => 'MEDIO',
        ]) ;
        Prioridad::create([
            'nivel' => 3 ,
            'nombre' => 'INTERMEDIO',
        ]) ;
        Prioridad::create([
            'nivel' => 4 ,
            'nombre' => 'ALTO',
        ]) ;
        Prioridad::create([
            'nivel' => 5 ,
            'nombre' => 'URGENTE',
        ]) ;

        //creacion de Tipos de reclamos
        TipoReclamo::create([
            'nombre' => 'RUPTURA CAÑO PVC' ,
            'trabajo' => 1 ,
            'prioridad_id' => 4 ,
            'flujoTrabajo_id' => 1,

        ]) ;
        TipoReclamo::create([
            'nombre' => 'CAMBIO DE MEDIDOR' ,
            'trabajo' => 1 ,
            'prioridad_id' => 3 ,
            'flujoTrabajo_id' => 1,

        ]) ;
        TipoReclamo::create([
            'nombre' => 'PERDIDA DE MANGUERA' ,
            'trabajo' => 1 ,
            'prioridad_id' => 2 ,
            'flujoTrabajo_id' => 1,
        ]) ;
        TipoReclamo::create([
            'nombre' => 'QUEJAS DEL SOCIO' ,
            'trabajo' => 0 ,
            'prioridad_id' => 1 ,
            'flujoTrabajo_id' => 2,

        ]) ;
        TipoReclamo::create([
            'nombre' => 'RUPTURA DEL CAÑO PRINCIPAL' ,
            'trabajo' => 1 ,
            'prioridad_id' => 5 ,
            'flujoTrabajo_id' => 1,

        ]) ;
    }
}
