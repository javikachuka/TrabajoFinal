<?php

use Illuminate\Database\Seeder;
use App\User ;
use App\Rol ;
use App\Domicilio ;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $domicilio = new Domicilio();
        $domicilio->barrio_id = 1 ;
        $domicilio->calle = 'null' ;
        $domicilio->altura = 0 ;
        $domicilio->save() ;

        $user = new User() ;
        $user->name = 'admin' ;
        $user->apellido = 'admin' ;
        $user->dni = '0' ;
        $user->domicilio_id = $domicilio->id ;
        $user->fecha_ingreso = new DateTime('now');
        $user->telefono = 0 ;
        $user->email = 'admin@admin.com' ;
        $user->password = Hash::make('123456789') ;
        $user->save() ;

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
