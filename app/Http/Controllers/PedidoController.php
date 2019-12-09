<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\Detalle;
use App\Pedido;
use App\Producto;
use App\Proveedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::all();
        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $pedidos = Pedido::all();
        $num_pedido = 0;
        if (!$pedidos->isEmpty()) {
            $pedidos->last();
            $num_pedido = $pedidos->last()->id + 1;
        } else {
            $num_pedido = 1;
        }

        return view('pedidos.create', compact('proveedores', 'productos', 'num_pedido'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $pedido = new Pedido();
            $pedido->fecha = $request->fecha;
            $pedido->proveedor_id = $request->proveedor_id;
            $pedido->user_id = auth()->user()->id;
            $pedido->save();

            for ($i = 0; $i < sizeof($request->cantidad); $i++) {
                $detalle = new Detalle();
                $detalle->pedido_id = $pedido->id;
                $detalle->producto_id = $request->producto_id[$i];
                $detalle->cantidad = $request->cantidad[$i];
                $detalle->save();
            }
            DB::commit();
            return redirect()->route('pedidos.index')->with('confirmar', 'ok');
        } catch (Exception $e) {
            DB::rollback();
            alert()->error($e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        $config = Configuracion::first();
        return view('pedidos.show', compact('pedido', 'config'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        return view('pedidos.edit', compact('pedido', 'proveedores', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        // return $request;
        // if (sizeof($request->producto_id) > sizeof($pedido->detalles)) {
        //     for ($i = 0; $i < sizeof($request->producto_id); $i++) {
        //         if (!$pedido->detalles->contains('producto_id', $request->producto_id[$i])) {
        //             $detalle = new Detalle();
        //             $detalle->pedido_id = $pedido->id;
        //             $detalle->producto_id = $request->producto_id[$i];
        //             $detalle->cantidad = $request->cantidad[$i];
        //             $detalle->save();
        //         }
        //     }
        // }
        foreach ($pedido->detalles as $d) {
            $d->delete();
        }
        for ($i = 0; $i < sizeof($request->producto_id); $i++) {
            $detalle = new Detalle();
            $detalle->pedido_id = $pedido->id;
            $detalle->producto_id = $request->producto_id[$i];
            $detalle->cantidad = $request->cantidad[$i];
            $detalle->save();
        }


        $pedido->proveedor_id = $request->proveedor_id;
        $pedido->generado = true;
        $pedido->user_id = auth()->user()->id;
        $pedido->update();
        return redirect()->route('pedidos.index')->with('confirmar', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        try {
            $pedido->delete();
            return redirect()->back()->with('borrado', 'ok');
        } catch (Exception $e) {
            alert()->error('No es posible eliminar', 'Error');
            return redirect()->back();
        }
    }
}
