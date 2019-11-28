<?php

namespace App\Http\Controllers;

use App\Asistencia;
use App\Horario;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $dia = Carbon::now()->format('Y-m-d');
        $asistencia = new Asistencia();
        $asistencias = $user->asistencias;
        $asistencias = $asistencias->sortByDesc('dia');

        return view('asistencia.index', compact('user', 'asistencias'));
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
     * @param  \App\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function show(User $empleado)
    {
        return view('asistencia.controlVer', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Asistencia $asistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     *   @param  \App\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asistencia $asistencia)
    {
        //
    }

    public function entrada(Request $request)
    {

        $asisEmpleado = Asistencia::where('dia', Carbon::now()->format('Y-m-d'))->where('user_id', auth()->user()->id)->get();
        $horaActual = Carbon::now()->format('H:i:s');
        if (!empty($asisEmpleado[0])) {
            foreach ($asisEmpleado as $asistencia) {
                // && (strtotime($horaActual) <= strtotime($asistencia->horaSalida))
                if ((strtotime($horaActual) >= strtotime($asistencia->horaEntrada))) {
                    if ($asistencia->horaSalida != null) {
                        if (strtotime($horaActual) <= strtotime($asistencia->horaSalida)) {
                            alert()->info('Usted ya ha marcado su entrada del dia');
                            return redirect()->back();
                        }
                    } else {
                        // $horaTrabajoNormal = "08:00:00" ;
                        // return  (strtotime($horaActual) - strtotime($asistencia->horaEntrada)) /3600 ;
                        if (((strtotime($horaActual) - strtotime($asistencia->horaEntrada)) / 3600) < 6.5) {
                            alert()->info('Usted ya ha marcado su entrada del dia');
                            return redirect()->back();
                        }
                    }
                }
            }
        }
        $asistencia = new Asistencia();
        $asistencia->dia = Carbon::now();
        $asistencia->horaEntrada  = Carbon::now('America/Argentina/Buenos_Aires')->format('H:i:s');
        $asistencia->presente = true;
        $asistencia->user_id = auth()->user()->id;
        if ($request->dni == null) {
            $encoded_data = $_POST['fotoEntrada'];
            $binary_data = base64_decode($encoded_data);
            $name = time() . auth()->user()->name . auth()->user()->apellido . ".png";
            $result = file_put_contents(public_path('/img/asistencias/') . $name, $binary_data);
            if (!$result) {
                alert()->error('No se pudo almacenar la foto', 'Error');
                return redirect()->back();
            }
            $asistencia->urlFoto = $name;
        }

        $asistencia->save();

        return redirect()->back()->with('confirmar', 'ok');
    }

    public function salida()
    {
        $asisEmpleado = Asistencia::where('dia', Carbon::now()->format('Y-m-d'))->where('user_id', auth()->user()->id)->get();
        $horaActual = Carbon::now()->format('H:i:s');
        if (!empty($asisEmpleado[0])) {
            foreach ($asisEmpleado as $asistencia) {
                if ($asistencia->horaSalida == null) {
                    // return (strtotime($horaActual) - strtotime($asistencia->horaEntrada))/3600 ;
                    if (((strtotime($horaActual) - strtotime($asistencia->horaEntrada)) / 3600) <= 8.5) {
                        $asistencia->horaSalida = $horaActual;
                        $asistencia->update();
                        auth()->logout();
                        return redirect('/');
                    }
                }
            }
        } else {
            alert()->error('Usted no ha marcado entrada!', 'Error');
            return redirect()->back();
        }
    }

    public function control()
    {
        $empleados = User::all();
        $asistencias = Asistencia::all();
        foreach ($empleados as $key => $e) {
            if ($e->roles->first()->name != 'EMPLEADO_PLANTA') {
                $empleados->pull($key);
            }
        }
        // $hora = Carbon::create($asistencias[0]->horaEntrada);
        // $horarios = Horario::all() ;
        //  $horaE = Carbon::create($horarios[0]->horaEntrada);
        //  $horaS = Carbon::create($horarios[0]->horaSalida);
        // if($hora->greaterThanOrEqualTo($horaE) && $hora->lessThanOrEqualTo($horaS)) {
        //     return 'si0' ;

        // } else{
        //     return 'no';
        // }
        return view('asistencia.control', compact('empleados', 'asistencias'));
    }

    public function obtener($id)
    {
        $empleado = User::find($id);
        $fechas = collect();
        foreach ($empleado->asistencias as $a) {
            $fechas->add($a->getDia());
        }
        return ['asistencias' => $empleado->asistencias, 'fechas' => $fechas];
    }

    public function obtenerAsistencias(Request $request)
    {
        $empleado = User::find($request->empleado_id);
        // return view('asistencia.controlVer', compact('empleado')) ;
        return  redirect()->route('asistencias.show', $empleado);
    }

    public function validar()
    {
        return request()->validate([
            'fotoEntrada' => 'required',
        ]);
    }

    public function comprobarDni($dni, $id)
    {
        $user = User::find($id);
        if ($user->dni == $dni) {
            return 1;
        } else {
            return 0;
        }
    }
}
