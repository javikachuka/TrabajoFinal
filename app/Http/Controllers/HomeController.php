<?php

namespace App\Http\Controllers;

use App\Estado;
use App\Producto;
use App\Proveedor;
use App\Reclamo;
use App\Trabajo;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('principal.principal');
        return redirect()->route('inicio');
    }

    public function inicio()
    {
        if(auth()->user()->roles->first()->name == 'EMPLEADO_PLANTA' || auth()->user()->roles->first()->name == 'ADMIN' ){

            $trabajos = Trabajo::all()->where('estado_id', 2);
            $trabajosOrdenados = collect();
            foreach ($trabajos as $key => $trabajo) {
                // if ($trabajo->estado->nombre != 'EN ESPERA') {
                //     $trabajos->pull($key);
                // }
                // if (sizeof($trabajo->reclamo->tipoReclamo->requisitos) != sizeof($trabajo->reclamo->controles)) {
                //     $trabajos->pull($key);
                // }
                if (!$trabajo->users->isEmpty()) {
                    if ($trabajo->users->contains(auth()->user())) {
                        $trabajosOrdenados->add($trabajo);
                    }
                } else {
                    $trabajosOrdenados->add($trabajo);
                }
            }




            // for ($i = 0; $i < sizeof($trabajosOrdenados); $i++) {

            //     if ($trabajosOrdenados[$i]->reclamo->tipoReclamo->prioridad->nivel < $max) {
            //         $max = $trabajosOrdenados[$i]->reclamo->tipoReclamo->prioridad->nivel;
            //     } else {
            //         $aux = $trabajosOrdenados[$i - 1];
            //         $trabajosOrdenados[$i - 1] = $trabajosOrdenados[$i];
            //         $trabajosOrdenados[$i] = $aux;
            //     }
            // }
            // dd($trabajos);
            // $trabajosOrdenados = $trabajosOrdenados->sortByDesc('Nivel') ;

            //burbuja para ordenar los de mayor prioridad
            $aux = null;
            $max = 2200;
            for ($i = 1; $i < count($trabajosOrdenados); $i++) {
                for ($j = 0; $j < count($trabajosOrdenados) - $i; $j++) {
                    if ($trabajosOrdenados[$j]->reclamo->tipoReclamo->prioridad->nivel < $trabajosOrdenados[$j + 1]->reclamo->tipoReclamo->prioridad->nivel) {
                        $k = $trabajosOrdenados[$j + 1];
                        $trabajosOrdenados[$j + 1] = $trabajosOrdenados[$j];
                        $trabajosOrdenados[$j] = $k;
                    }
                }
            }

            //burbuja para los de mayor tiempo segun prioridad de cada uno, si tienen igual prioridad se compara el tiempo de duracion
            for ($i = 1; $i < count($trabajosOrdenados); $i++) {
                for ($j = 0; $j < count($trabajosOrdenados) - $i; $j++) {
                    if (($trabajosOrdenados[$j]->reclamo->tipoReclamo->prioridad == $trabajosOrdenados[$j + 1]->reclamo->tipoReclamo->prioridad) && ($trabajosOrdenados[$j]->duracionEstimadaReal($trabajosOrdenados[$j]->reclamo->tipoReclamo->id) < $trabajosOrdenados[$j + 1]->duracionEstimadaReal($trabajosOrdenados[$j + 1]->reclamo->tipoReclamo->id))) {
                        $k = $trabajosOrdenados[$j + 1];
                        $trabajosOrdenados[$j + 1] = $trabajosOrdenados[$j];
                        $trabajosOrdenados[$j] = $k;
                    }
                }
            }

            $estadoIniciado = Estado::where('nombre', 'INICIADO')->firstOrFail();
            $trabajosIniciados = Trabajo::where('estado_id', $estadoIniciado->id)->get();

        }

        $cantidadReclamos = Reclamo::all()->count() ;
        $cantidadProveedores = Proveedor::all()->count() ;
        $cantidadEmpleados = User::all()->count() ;
        $cantidadProductos = Producto::all()->count() ;
        return view('inicio', compact('trabajosOrdenados', 'trabajosIniciados',  'cantidadReclamos', 'cantidadProveedores' , 'cantidadEmpleados', 'cantidadProductos'));
    }
}
