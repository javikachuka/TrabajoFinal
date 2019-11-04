<?php

namespace App\Http\Controllers;

use App\Proveedor;
use Alert ;
use App\Producto;
use Exception;
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
        $productos = Producto::all() ;
        return view('proveedores.registro', compact('proveedor', 'productos')) ;
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
        $proveedor->productos()->sync($request->input('productos', [])) ;
        return redirect('/proveedores')->with('confirmar' , 'guardado') ;

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
        $productos = Producto::all() ;
        return view('proveedores.edit' , compact('proveedor' , 'productos'));

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
        $validator = Validator::make($request->all(), [
            'nombre' => 'required' ,
            'cuit' => 'required|string|min:13|unique:proveedores,cuit,'.$id ,
            'email' => 'required|email' ,
            'telefono' => 'numeric|required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $proveedor = Proveedor::find($id) ;
        $proveedor->fill($request->all()) ;
        $proveedor->save() ;
        $proveedor->productos()->sync($request->input('productos', [])) ;
        return redirect('/proveedores')->with('confirmar' , 'guardado') ;
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
        try{
            if($proveedor != null){
                $proveedor->delete() ;
                return redirect()->back()->with('borrado' , 'guardado') ;
            }
        }catch(Exception $e){
            alert()->error('No es posible eliminar' , 'Error!') ;
            return redirect('/proveedores') ;
        }
    }

    public function validar(){
        $data = request()->validate([
            'nombre' => 'required' ,
            'cuit' => 'required|string|min:13|unique:proveedores,cuit' ,
            'email' => 'required|email' ,
            'telefono' => 'numeric|required'
        ]);
    }
}
