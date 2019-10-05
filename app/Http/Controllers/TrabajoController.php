<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\CabeceraMovimiento;
use App\HistorialEstado;
use App\Movimiento;
use App\Producto;
use App\Trabajo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class TrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trabajos = Trabajo::all() ;
        $estados = collect() ;
        if(!empty($trabajos[0])){
            $estados = $trabajos[0]->reclamo->tipoReclamo->flujoTrabajo->getEstados() ;
        }
        $productos = Producto::all() ;
        return view('trabajos.index' , compact('trabajos', 'estados' , 'productos' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function show(Trabajo $trabajo)
    {
        return view('trabajos.show' , compact('trabajo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function edit(Trabajo $trabajo)
    {
        $empleados = User::all() ;
        return view('trabajos.asignacionTrabajos', compact('trabajo', 'empleados')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trabajo $trabajo)
    {
        if($request->empleados != null){
            $trabajo->users()->sync($request->input('empleados', [])) ;
            return redirect()->route('trabajos.index')->with('confirmar' , 'ok') ;
        }else{
            alert()->error('Por favor seleccione un/os empleado/s para asignar el trabajo', 'Error!') ;
            return redirect()->back() ;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trabajo $trabajo)
    {
        //
    }

    public function iniciarTrabajo(Trabajo $trabajo){

        if(sizeof($trabajo->reclamo->tipoReclamo->requisitos) == sizeof($trabajo->reclamo->controles)){
            if(!empty($trabajo->users[0])){
                if(!$trabajo->users->contains(auth()->user())) {
                    alert()->error('Solamente el personal designado puede realizar este trabajo!')->persistent('Ok') ;
                    return redirect()->back() ;
                }
            }
            $siguienteEstado = $trabajo->reclamo->tipoReclamo->flujoTrabajo->siguienteEstado($trabajo->estado) ;
            $trabajo->estado_id = $siguienteEstado->id ;
            $trabajo->horaInicio = Carbon::now('America/Argentina/Buenos_Aires') ;
            $trabajo->update() ;
            $historial = new HistorialEstado() ;
            $historial->reclamo_id = $trabajo->reclamo->id ;
            $historial->estado_id = $siguienteEstado->id ;
            $historial->save() ;
            return redirect()->back()->with('confirmar', 'ok') ;
        }else{
            alert()->error('No es posible comenzar el trabajo debido a que hay documentaciones sin presentar!')->persistent('Ok') ;
            return redirect()->route('trabajos.index') ;
        }
    }

    public function finalizarTrabajo(Trabajo $trabajo){
        $productos = Producto::all() ;
        $almacenes = Almacen::all() ;
        $empleados = User::all() ;

        // foreach($empleados as $key => $empleado){
        //     if($empleado->)
        // }

        return view('trabajos.finTrabajo', compact('trabajo', 'productos', 'almacenes', 'empleados'));
    }

    public function guardarFinalizacion(Request $request, Trabajo $trabajo){


        DB::beginTransaction();

        $almacenOrigen = Almacen::find($request->almacen_id);
        $trabajo->horaFin = Carbon::now() ;
        $trabajo->observacion = $request->observacion ;
        $cabMov = new CabeceraMovimiento() ;
        $cabMov->fecha = Carbon::now();
        $cabMov->save();
        for ($i=0; $i < sizeof($request->cantidad); $i++) {
            $movimiento = new Movimiento() ;
            $movimiento->cantidad = $request->cantidad[$i] ;
            $movimiento->tipo_movimiento_id = 2 ;
            $movimiento->cabecera_movimiento_id = $cabMov->id ;
            $movimiento->almacenOrigen_id = $almacenOrigen->id ;
            $movimiento->producto_id = $request->producto[$i] ;
            if($almacenOrigen->existeProducto($request->producto[$i])){
                if($request->cantidad[$i] <= $almacenOrigen->getCantidadProd($request->producto[$i])){
                    $exis1 = $almacenOrigen->existencias ;
                    foreach($exis1 as $e1){
                        if($e1->producto->id == $request->producto[$i]){
                            $e1->cantidad -= $request->cantidad[$i] ;
                            $e1->update() ;
                        }
                    }
                    $movimiento->save() ;
                }else{
                    DB::rollback();
                    alert()->error('La cantidad/es ingresa/s supera/n a lo disponible!', 'Error')->persistent('OK') ;
                    return redirect()->back() ;
                }
            }else{
                DB::rollback();
                alert()->error('No hay existencias en el almacen '. $almacenOrigen->denominacion. ' del/los producto/s ingresado/s!', 'Error')->persistent('OK') ;
                return redirect()->back() ;
            }
        }
        //cambiando de estado el trabajo
        $siguienteEstado = $trabajo->reclamo->tipoReclamo->flujoTrabajo->siguienteEstado($trabajo->estado) ;
        $trabajo->estado_id = $siguienteEstado->id ;
        $trabajo->horaInicio = Carbon::now('America/Argentina/Buenos_Aires') ;

        //asociando cabecera a un trabajo
        $cabMov->trabajo_id = $trabajo->id ;

        //subiendo la foto del trabajo
        if($request->hasFile('fotoFin')){
            $file = $request->file('fotoFin') ;
            $name = $request->file('fotoFin')->getClientOriginalName();
            $img = Image::make($file)->resize(320, 240);
            $img->save(public_path('/img/trabajos/').$name) ;
            $trabajo->urlFoto = $name ;
            // return $img->response('jpg');
            // $img->move(public_path('/img/trabajos/') , $name) ;
        }
        $trabajo->update() ;

        //asociando el trabajo a los empleados
        $trabajo->users()->sync($request->input('empleados' , [])) ;

        //creando el historial del reclamo
        $historial = new HistorialEstado() ;
        $historial->reclamo_id = $trabajo->reclamo->id ;
        $historial->estado_id = $siguienteEstado->id ;
        $historial->save() ;

        DB::commit();

        return redirect()->route('trabajos.index')->with('confirmar' , 'ok') ;
    }
}
