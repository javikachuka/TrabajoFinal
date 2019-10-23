<?php

namespace App\Http\Controllers;

use App\Charts\Estadistica;
use App\Reclamo;
use App\TipoReclamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticaController extends Controller
{
    public function trabajo()
    {



        $prueba = new Estadistica;
        $trabajosMasFrecuentes = new Estadistica;
        $tipos = TipoReclamo::all()->where('flujoTrabajo_id',  1);
        $nom = collect() ;
        $duracion = collect() ;
        $cantidad = collect() ;
        foreach($tipos as $t){
            $nom->add($t->nombre);
            if($t->reclamos->first() != null){
                $duracion->add($t->reclamos->first()->trabajo->duracionEstimadaReal($t->id)) ;
                $cantidad->add(Reclamo::where('tipoReclamo_id', $t->id)->get()->count());

            }else{
                $duracion->add(0);
                $cantidad->add(0);
            }
        }
        $trabajosMasFrecuentes->labels($nom) ;
        $trabajosMasFrecuentes->title('Trabajos mas Frecuentes') ;
        $trabajosMasFrecuentes->dataset('Frecuencia', 'bar', $cantidad)->backgroundColor("rgba(54, 162, 235, 0.2)");

        $prueba->labels($nom);
        $prueba->title('Tiempo de Duracion de los Trabajos');
        // $prueba->dataset('My dataset', 'bar', [1, 2, 3, 4]);
        $prueba->dataset('Duracion Real', 'bar', $duracion)->backgroundColor("rgba(75, 192, 192, 0.2)");
        return view('trabajos.estadistica' , compact('prueba', 'trabajosMasFrecuentes'));
    }
}
