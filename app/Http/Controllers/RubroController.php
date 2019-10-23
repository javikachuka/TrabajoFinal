<?php

namespace App\Http\Controllers;

use App\Rubro;
use Exception;
use Illuminate\Http\Request;

class RubroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rubros = Rubro::all();
        return view('rubros.index', compact('rubros'));
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
        $this->validar();
        $rubro = new Rubro();
        $rubro->fill($request->all());
        $rubro->save();
        return redirect()->back()->with('confirmar', 'ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function show(Rubro $rubro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function edit(Rubro $rubro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rubro = Rubro::find($id);
        $rubro->fill($request->all());
        $rubro->update();
        return redirect()->back()->with('confirmar', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rubro $rubro)
    {
        try {
            if ($rubro->productos->isEmpty()) {
                $rubro->delete();
                return redirect()->back()->with('borrado', 'ok');
            } else {
                alert()->error('No es posible eliminar el Rubro debido a que esta siendo utilizado por un producto', 'Error');
                return redirect()->back();
            }
        } catch (Exception $e) {
            alert()->error($e);
            return redirect()->back();
        }
    }

    public function validar()
    {
        $data = request()->validate([
            'nombre' => 'required|unique:rubros,nombre',
        ], [
            'nombre.unique' => 'El rubro ya existe'
        ]);
    }
}
