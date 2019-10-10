<?php

namespace App\Http\Controllers;

use App\Trabajo;
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
        return view('principal.principal');
    }

    public function inicio(){
        $trabajos = Trabajo::all();
        foreach($trabajos as $key => $trabajo){
            if($trabajo->reclamo->getCantidadEstados() != 2){
                $trabajos->pull($key) ;
            }
            if(sizeof($trabajo->reclamo->tipoReclamo->requisitos) != sizeof($trabajo->reclamo->controles)){
                $trabajos->pull($key) ;
            }
        }
        return view('inicio' , compact('trabajos')) ;
    }
}
