<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Role;

class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'          => 'ADMIN',
            'slug'          => 'admin',
            'desciption'    => 'puede hacer de todo' ,
        ]);

        Role::create([
            'name'          => 'EMPLEADO_OFICINA',
            'slug'          => 'empleado_oficina',
            'desciption'    => 'acceso medio' ,
        ]);

        Role::create([
            'name'          => 'EMPLEADO_PLANTA',
            'slug'          => 'empleado_planta',
            'desciption'    => 'acceso medio' ,
        ]);

    }
}
