<?php

use Illuminate\Database\Seeder;
use App\Rol ;

class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol = new Rol() ;
        $rol->nombre = 'admin' ;
        $rol->descripcion = 'Administrador General' ;
        $rol->save() ;

        $rol = new Rol() ;
        $rol->nombre = 'empleadoPlanta' ;
        $rol->descripcion = 'Empleado que trabaja en el sector planta' ;
        $rol->save() ;

        $rol = new Rol() ;
        $rol->nombre = 'empleadoOficina' ;
        $rol->descripcion = 'Empleado que trabaja en la oficina de la cooperativa' ;
        $rol->save() ;
    }
}
