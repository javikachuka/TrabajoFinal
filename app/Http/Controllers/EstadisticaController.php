<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Charts\Estadistica;
use App\Movimiento;
use App\Producto;
use App\Reclamo;
use App\TipoReclamo;
use App\Zona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticaController extends Controller
{
    public function trabajo()
    {
        $prueba = new Estadistica;
        $trabajosMasFrecuentes = new Estadistica;
        $tipos = TipoReclamo::all()->where('flujoTrabajo_id',  1);
        $nom = collect();
        $nom2 = collect();
        $duracion = collect();
        $cantidad = collect();
        foreach ($tipos as $t) {
            if ($t->reclamos->first() != null) {
                $nom->add($t->nombre);
                if ($t->reclamos->first()->trabajo->duracionEstimadaReal($t->id) != 0) {
                    $duracion->add($t->reclamos->first()->trabajo->duracionEstimadaReal($t->id));
                    $nom2->add($t->nombre);
                }
                $cantidad->add(Reclamo::where('tipoReclamo_id', $t->id)->get()->count());
            }
            // } else {
            //     $duracion->add(0);
            //     $cantidad->add(0);
            // }
        }
        $trabajosMasFrecuentes->labels($nom);
        // $trabajosMasFrecuentes->options([
        //     'scales' => [
        //         'yAxes' => [
        //             'display' => true,
        //             'labelString' => 'Horas' ,
        //         ]
        //     ]

        // ]);
        $trabajosMasFrecuentes->title('Trabajos mas Frecuentes');
        // $trabajosMasFrecuentes->options([
        //     'tooltip' => [
        //         'show' => true, // or false, depending on what you want.

        //     ],
        //     'scales' => [
        //         'xAxes' => [

        //             'display' => true,
        //             'scaleLabel' => [
        //                 'display' => true,
        //                 'labelString' => 'asdfga',
        //             ],
        //         ],
        //         'yAxes' => [
        //             'display' => true,
        //             'scaleLabel' => [
        //                 'display' => true,
        //                 'labelString' => 'asdfga',
        //             ],
        //         ],
        //     ],
        // ]);
        // $trabajosMasFrecuentes->options([
        //     'scales' => [
        //       'xAxes' => [

        //         'display' => true,
        //         'scaleLabel' => [
        //             'display' => true,
        //             'labelString' => 'asdfga',
        //         ],
        //       ],
        //       'yAxes' => [
        //         'display' => true,
        //         'scaleLabel' => [
        //             'display' => true,
        //             'labelString' => 'asdfga',
        //         ],
        //       ],
        //     ],
        //   ]);
        $trabajosMasFrecuentes->dataset('Frecuencia', 'bar', $cantidad)->color("rgba(54, 162, 235)")->backgroundColor("rgba(54, 162, 235, 0.2)");
        $trabajosMasFrecuentes->options([
            'scales'              => [
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Tipos de Trabajos',
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Frecuencia',
                        ]
                    ],
                ],
            ],
        ]);

        $prueba->labels($nom2);
        $prueba->title('Tiempo de Duracion de los Trabajos');
        $prueba->options([
            'scales'              => [
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Tipos de Trabajos',
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Minutos',
                        ]
                    ],
                ],
            ],
        ]);
        // $prueba->dataset('My dataset', 'bar', [1, 2, 3, 4]);
        $prueba->dataset('Duracion Promedio', 'bar', $duracion)->color("rgba(75, 192, 192)")->backgroundColor("rgba(75, 192, 192, 0.2)");
        return view('trabajos.estadistica', compact('prueba', 'trabajosMasFrecuentes'));
    }

    public function almacen()
    {
        $estadisAlmacen = new Estadistica;
        $almacenes = Almacen::all();
        $estadisAlmacen->title('Productos Utilizados por Almacen');
        $productos = Producto::all();

        $almacenes = Almacen::all();
        // $movimientos = Movimiento::where('tipo_movimiento_id', 2)->get() ;
        // return $movimientos;
        // foreach($almacenes as $almacen){
        // $almacen = $almacenes->first();
        //     $productos = collect() ;
        //     $cantidad = collect() ;
        //     foreach($almacen->movimientosOrigen as $m){
        //         $aux = 0 ;
        //         if(!$productos->contains($m->producto->nombre)){
        //             $productos->add($m->producto->nombre) ;
        //             foreach($almacen->movimientosOrigen as $movi){
        //                 if($movi->producto->id == $m->producto->id){
        //                     $aux += $movi->cantidad ;
        //                 }
        //             }
        //             $cantidad->add($aux) ;
        //         }
        //     }
        //     $estadisAlmacen->labels($productos) ;
        //     $estadisAlmacen->dataset($almacen->denominacion, 'bar' , $cantidad) ;
        // }
        $nombres = collect();
        foreach ($productos as $p) {
            $nombres->add($p->nombre);
        }
        $estadisAlmacen->labels($nombres);
        foreach ($almacenes as $a) {
            $cantidades = collect();
            foreach ($productos as $p) {
                $nombres->add($p->nombre);
                $cantidades->add($p->getCantidadEgreso($a));
            }
            $r = rand(50, 200);
            $g = rand(50, 200);
            $b = rand(50, 200);
            $estadisAlmacen->dataset($a->denominacion, 'bar', $cantidades)->color("rgb(" . $r . "," . $g . "," . $b . ")")->backgroundColor("rgba(" . $r . "," . $g . "," . $b . ", 0.2)");
            // $estadisAlmacen->dataset($a->denominacion, 'bar' , $cantidades)->color("rgb(255,99,132)") ;
        }

        $estadisAlmacen->options([
            'scales'              => [
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Productos',
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Cantidad Utilizada',
                        ]
                    ],
                ],
            ],
        ]);

        return view('almacenes.estadistica', compact('estadisAlmacen', 'almacenes'));
    }

    public function reclamo()
    {
        $anio = 2016;
        $ahora = Carbon::now()->year;
        $anios = collect();
        for ($i = $anio; $i <= $ahora + 5; $i++) {
            $anios->add($i);
        }
        $estadisReclamos = new Estadistica;
        $estadisReclamos->title('Zonas con Mas Reclamos');
        $zonas = Zona::all();
        $tipoReclamos = TipoReclamo::all();
        $nombres = collect();
        $cantReclamos = collect();

        foreach ($zonas as $zona) {
            $cantidad = DB::table('zonas')
                ->join('direcciones', 'zonas.id', '=', 'direcciones.zona_id')
                ->join('reclamos', 'direcciones.id', '=', 'reclamos.direccion_id')
                ->select('zonas.*', 'reclamos.tipoReclamo_id')->where('zonas.id', $zona->id)->get()->count();
            if ($cantidad != 0) {
                $nombres->add($zona->nombre);
                $cantReclamos->add($cantidad);
            }
        }

        $estadisReclamos->labels($nombres);

        $estadisReclamos->options([
            'scales'              => [
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Zonas',
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Cantidad de Reclamos',
                        ]
                    ],
                ],
            ],
        ]);

        $r = rand(50, 200);
        $g = rand(50, 200);
        $b = rand(50, 200);
        $estadisReclamos->dataset('Zonas', 'bar', $cantReclamos)->color("rgb(" . $r . "," . $g . "," . $b . ")")->backgroundColor("rgba(" . $r . "," . $g . "," . $b . ", 0.2)");
        $anio = null;
        $tip = null;
        return view('reclamos.estadistica', compact('estadisReclamos', 'tipoReclamos', 'tip', 'anios', 'anio'));
    }

    public function filtroZonas($anio, $tip)
    {
        $anio2 = 2016;
        $ahora = Carbon::now()->year;
        $anios = collect();
        for ($i = $anio2; $i <= $ahora + 5; $i++) {
            $anios->add($i);
        }
        $zonas = Zona::all();
        $tipoReclamos = TipoReclamo::all();
        $estadisReclamos = new Estadistica;
        $estadisReclamos->title('Zonas con Mas Reclamos');

        if ($anio != 0 && $tip == 0) {
            $fecha = Carbon::create($anio)->format('Y-m-d');
            $fin = Carbon::create($anio + 1)->format('Y-m-d');

            $nombres = collect();
            $cantReclamos = collect();

            foreach ($zonas as $zona) {
                $cantidad = DB::table('zonas')
                    ->join('direcciones', 'zonas.id', '=', 'direcciones.zona_id')
                    ->join('reclamos', 'direcciones.id', '=', 'reclamos.direccion_id')
                    ->select('zonas.*', 'reclamos.tipoReclamo_id')->where('zonas.id', $zona->id)->where('reclamos.fecha', '>=', $fecha)->where('reclamos.fecha', '<', $fin)->get()->count();
                if ($cantidad != 0) {
                    $nombres->add($zona->nombre);
                    $cantReclamos->add($cantidad);
                }
            }
        } elseif ($anio == 0 && $tip != 0) {
            $nombres = collect();
            $cantReclamos = collect();

            foreach ($zonas as $zona) {
                $cantidad = DB::table('zonas')
                    ->join('direcciones', 'zonas.id', '=', 'direcciones.zona_id')
                    ->join('reclamos', 'direcciones.id', '=', 'reclamos.direccion_id')
                    ->select('zonas.*', 'reclamos.tipoReclamo_id')->where('zonas.id', $zona->id)->where('reclamos.tipoReclamo_id', $tip)->get()->count();
                if ($cantidad != 0) {
                    $nombres->add($zona->nombre);
                    $cantReclamos->add($cantidad);
                }
            }
            $anio == null;
        } elseif ($anio != 0 && $tip != 0) {
            $fecha = Carbon::create($anio)->format('Y-m-d');
            $fin = Carbon::create($anio + 1)->format('Y-m-d');

            $nombres = collect();
            $cantReclamos = collect();

            foreach ($zonas as $zona) {
                $cantidad = DB::table('zonas')
                    ->join('direcciones', 'zonas.id', '=', 'direcciones.zona_id')
                    ->join('reclamos', 'direcciones.id', '=', 'reclamos.direccion_id')
                    ->select('zonas.*', 'reclamos.tipoReclamo_id')->where('zonas.id', $zona->id)->where('reclamos.fecha', '>=', $fecha)->where('reclamos.fecha', '<', $fin)->where('reclamos.tipoReclamo_id', $tip)->get()->count();
                if ($cantidad != 0) {
                    $nombres->add($zona->nombre);
                    $cantReclamos->add($cantidad);
                }
            }
        }


        $estadisReclamos->labels($nombres);

        $estadisReclamos->options([
            'scales'              => [
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Zonas',
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => 'Cantidad de Reclamos',
                        ]
                    ],
                ],
            ],
        ]);

        $r = rand(50, 200);
        $g = rand(50, 200);
        $b = rand(50, 200);
        $estadisReclamos->dataset('Zonas', 'bar', $cantReclamos)->color("rgb(" . $r . "," . $g . "," . $b . ")")->backgroundColor("rgba(" . $r . "," . $g . "," . $b . ", 0.2)");

        return view('reclamos.estadistica', compact('estadisReclamos', 'tipoReclamos', 'tip', 'anios', 'anio'));
    }
}
