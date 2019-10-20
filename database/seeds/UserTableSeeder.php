<?php

use Illuminate\Database\Seeder;
use App\User ;
use App\Rol ;
use App\Direccion ;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $direccion = new Direccion();
        $direccion->zona_id = 1 ;
        $direccion->calle = 'Las Heras' ;
        $direccion->altura = 115 ;
        $direccion->save() ;


        $user = new User() ;
        $user->name = 'Javier' ;
        $user->apellido = 'Kachuka' ;
        $user->dni = '40565646' ;
        $user->direccion_id = $direccion->id ;
        $user->fecha_ingreso = new DateTime('now');
        $user->telefono = 0 ;
        $user->email = 'admin@admin.com' ;
        $user->password = Hash::make('123456789') ;
        $user->save() ;
        $user->roles()->sync(1);

        $direccion = new Direccion();
        $direccion->zona_id = 4 ;
        $direccion->calle = 'Malvinas' ;
        $direccion->altura = 87 ;
        $direccion->save() ;


        $direccion = new Direccion();
        $direccion->zona_id = 5 ;
        $direccion->calle = 'Av. Centenario' ;
        $direccion->altura = 695 ;
        $direccion->save() ;


        $direccion = new Direccion();
        $direccion->zona_id = 2 ;
        $direccion->calle = 'Av. 9 de Julio' ;
        $direccion->altura = 8789 ;
        $direccion->save() ;


        $direccion = new Direccion();
        $direccion->zona_id = 3 ;
        $direccion->calle = 'Laprida' ;
        $direccion->altura = 8531;
        $direccion->save() ;

        // $user = new User() ;
        // $user->name = 'emple1' ;
        // $user->email = 'emple@emple.com' ;
        // $user->password = '123' ;
        // $user->rol_id = $rol_empleadoPlanta[0]->id;
        // $user->save() ;

        // $user = new User() ;
        // $user->name = 'emple2' ;
        // $user->email = 'emple2@emple2.com' ;
        // $user->password = '123' ;
        // $user->rol_id = $rol_empleadoOficina[0]->id;
        // $user->save() ;

    }
}
