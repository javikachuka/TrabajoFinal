<?php

use App\Requisito;
use Illuminate\Database\Seeder;

class RequisitosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Requisito::create([
            'nombre' => 'Fotocopia de DNI'
        ]) ;

        Requisito::create([
            'nombre' => 'Nº de Conexion'
        ]) ;

        Requisito::create([
            'nombre' => 'Certificado de Domicilio'
        ]) ;

        Requisito::create([
            'nombre' => 'Boleta de Servicio'
        ]) ;

        Requisito::create([
            'nombre' => 'Certificado Municipal'
        ]) ;


    }
}
