<?php

use App\Configuracion;
use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuracion::create([
            'logo' => 'logoCoop.jpg',
            'nombre' => 'COOPERATIVA DE AGUA POTABLE',
            'direccion' => 'Av. 9 de Julio 1368, San Jose - Misiones, Argentina',
            'telefono' => '(+54)3758655665',
            'email' => 'coop_agua@gmail.com',

        ]) ;
    }
}
