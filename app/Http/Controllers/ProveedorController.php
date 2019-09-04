<?php

namespace App\Http\Controllers;

use App\Proveedor;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $proveedores = Proveedor::all() ;

        return view('proveedores.index' , compact('proveedores')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedor = new Proveedor();
        return view('proveedores.registro', compact('proveedor')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Proveedor $proveedor)
    {
        $this->validar() ;

        $proveedor->fill($request->all()) ;
        $proveedor->save() ;
        return redirect('/proveedores') ;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $proveedor = Proveedor::find($id);

        return view('proveedores.edit' , compact('proveedor'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validar();
        $proveedor = Proveedor::find($id) ;
        $proveedor->fill($request->all()) ;
        $proveedor->save() ;

        return redirect('/proveedores') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::find($id) ;
        if($proveedor != null){
            $proveedor->delete() ;
        }
        return redirect('/proveedores') ;
    }

    public function validar(){
        $data = request()->validate([
            'nombre' => 'required' ,
            'cuit' => 'required' ,
            'email' => 'required|email' ,
            'telefono' => 'required'
        ]);
    }
}
