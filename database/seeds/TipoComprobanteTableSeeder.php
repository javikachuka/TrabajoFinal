<?php

use App\Almacen;
use App\TipoComprobante;
use Illuminate\Database\Seeder;

class TipoComprobanteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Almacen::create([
            'denominacion' => 'Almacen Sur',
            'direccion_id' => 1 ,
        ]) ;

        Almacen::create([
            'denominacion' => 'Almacen Norte',
            'direccion_id' => 1 ,
        ]) ;

        TipoComprobante::create([
            'nombre' => 'REMITO'
        ]) ;

        TipoComprobante::create([
            'nombre' => 'FACTURA A'
        ]) ;

        TipoComprobante::create([
            'nombre' => 'FACTURA B'
        ]) ;

        TipoComprobante::create([
            'nombre' => 'FACTURA C'
        ]) ;

        TipoComprobante::create([
            'nombre' => 'TICKET'
        ]) ;
    }
}
