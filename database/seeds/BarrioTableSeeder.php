<?php

use Illuminate\Database\Seeder;
use App\Barrio ;

class BarrioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $barrio = new Barrio() ;
        $barrio->nombre = 'Bº Malvinas' ;
        $barrio->save() ;

        $barrio = new Barrio() ;
        $barrio->nombre = 'Bº San Cayetano' ;
        $barrio->save() ;

        $barrio = new Barrio() ;
        $barrio->nombre = 'Bº 9 de Julio' ;
        $barrio->save() ;

        $barrio = new Barrio() ;
        $barrio->nombre = 'Bº Centro' ;
        $barrio->save() ;

        $barrio = new Barrio() ;
        $barrio->nombre = 'Bº Nuevo' ;
        $barrio->save() ;

        $barrio = new Barrio() ;
        $barrio->nombre = 'Bº La Tablada' ;
        $barrio->save() ;

        $barrio = new Barrio() ;
        $barrio->nombre = 'Bº Don Bosco' ;
        $barrio->save() ;
    }
}
