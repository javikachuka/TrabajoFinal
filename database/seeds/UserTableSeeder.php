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

        //admin
        $direccion = new Direccion();
        $direccion->zona_id = 1 ;
        $direccion->calle = 'Las Heras' ;
        $direccion->altura = 115 ;
        $direccion->save() ;


        $user = new User() ;
        $user->name = 'Javier' ;
        $user->apellido = 'Kachuka' ;
        $user->dni = '40.565.646' ;
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

        //empleados de planta
        $direccion = new Direccion();
        $direccion->zona_id = 1 ;
        $direccion->calle = 'Av. 9 De Julio' ;
        $direccion->altura = 779 ;
        $direccion->save() ;


        $user = new User() ;
        $user->name = 'Julio' ;
        $user->apellido = 'Pereira' ;
        $user->dni = '23.564.785' ;
        $user->direccion_id = $direccion->id ;
        $user->fecha_ingreso = new DateTime('now');
        $user->telefono = 3758964585 ;
        $user->email = 'julio@julio.com' ;
        $user->password = Hash::make('123456789') ;
        $user->save() ;
        $user->roles()->sync(3);


        $direccion = new Direccion();
        $direccion->zona_id = 6 ;
        $direccion->calle = 'Av. San Juan' ;
        $direccion->altura = 78 ;
        $direccion->save() ;


        $user = new User() ;
        $user->name = 'Hernan' ;
        $user->apellido = 'Lencina' ;
        $user->dni = '21.194.886' ;
        $user->direccion_id = $direccion->id ;
        $user->fecha_ingreso = new DateTime('now');
        $user->telefono = 3758759632 ;
        $user->email = 'lencina@lencina.com' ;
        $user->password = Hash::make('123456789') ;
        $user->save() ;
        $user->roles()->sync(3);

        //empleados de oficina
        $direccion = new Direccion();
        $direccion->zona_id = 2 ;
        $direccion->calle = 'La Rioja' ;
        $direccion->altura = 456 ;
        $direccion->save() ;


        $user = new User() ;
        $user->name = 'Omar' ;
        $user->apellido = 'Delgado' ;
        $user->dni = '14.563.785' ;
        $user->direccion_id = $direccion->id ;
        $user->fecha_ingreso = new DateTime('now');
        $user->telefono = 3758256312 ;
        $user->email = 'omar@omar.com' ;
        $user->password = Hash::make('123456789') ;
        $user->save() ;
        $user->roles()->sync(2);


        //encargados de Compra
        $direccion = new Direccion();
        $direccion->zona_id = 7 ;
        $direccion->calle = 'Los Colonos' ;
        $direccion->altura = 879 ;
        $direccion->save() ;


        $user = new User() ;
        $user->name = 'Victor' ;
        $user->apellido = 'Insaurralde' ;
        $user->dni = '24.758.654' ;
        $user->direccion_id = $direccion->id ;
        $user->fecha_ingreso = new DateTime('now');
        $user->telefono = 3758869656 ;
        $user->email = 'victor@victor.com' ;
        $user->password = Hash::make('123456789') ;
        $user->save() ;
        $user->roles()->sync(4);


        //auditor
        $direccion = new Direccion();
        $direccion->zona_id = 1 ;
        $direccion->calle = 's/n' ;
        $direccion->altura = 0 ;
        $direccion->save() ;


        $user = new User() ;
        $user->name = 'Auditor' ;
        $user->apellido = 'Auditor' ;
        $user->dni = '00.000.000' ;
        $user->direccion_id = $direccion->id ;
        $user->fecha_ingreso = new DateTime('now');
        $user->telefono = 0 ;
        $user->email = 'auditor@auditor.com' ;
        $user->password = Hash::make('123456789') ;
        $user->save() ;
        $user->roles()->sync(5);

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
