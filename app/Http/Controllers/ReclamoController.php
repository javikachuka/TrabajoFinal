<?php

namespace App\Http\Controllers;

use App\Reclamo;
use Illuminate\Http\Request;
use App\TipoReclamo ;
use App\Socio ;

class ReclamoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reclamos = Reclamo::all();

        $tip_rec = TipoReclamo::all() ;

        $socios = Socio::all() ;
        return view('reclamos.index',compact('reclamos','tip_rec','socios'));
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
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function show(Reclamo $reclamo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function edit(Reclamo $reclamo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reclamo $reclamo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reclamo  $reclamo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reclamo $reclamo)
    {
        //
    }


}
