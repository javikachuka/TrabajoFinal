<?php

use App\Almacen;
use App\TipoComprobante;
use App\TipoMovimiento;
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

        //esto es para almacen
        Almacen::create([
            'denominacion' => 'Almacen Sur',
            'direccion_id' => 1 ,
        ]) ;

        Almacen::create([
            'denominacion' => 'Almacen Norte',
            'direccion_id' => 1 ,
        ]) ;


        //esto es para los tipos de comprobantes
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

        //esto es para los tipos de movimientos
        TipoMovimiento::create([
            'nombre' => 'INGRESO' ,
            'operacion' => 1 ,
        ]) ;

        TipoMovimiento::create([
            'nombre' => 'EGRESO' ,
            'operacion' => 0 ,
        ]) ;

        TipoMovimiento::create([
            'nombre' => 'TRANSFERENCIA',
        ]) ;

    }
}
