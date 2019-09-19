<?php

use Illuminate\Database\Seeder;
use App\Zona ;

class ZonaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zona = new Zona() ;
        $zona->nombre = 'Bº Malvinas' ;
        $zona->save() ;

        $zona = new Zona() ;
        $zona->nombre = 'Bº San Cayetano' ;
        $zona->save() ;

        $zona = new Zona() ;
        $zona->nombre = 'Bº 9 de Julio' ;
        $zona->save() ;

        $zona = new Zona() ;
        $zona->nombre = 'Bº Centro' ;
        $zona->save() ;

        $zona = new Zona() ;
        $zona->nombre = 'Bº Nuevo' ;
        $zona->save() ;

        $zona = new Zona() ;
        $zona->nombre = 'Bº La Tablada' ;
        $zona->save() ;

        $zona = new Zona() ;
        $zona->nombre = 'Bº Don Bosco' ;
        $zona->save() ;

    }
}
