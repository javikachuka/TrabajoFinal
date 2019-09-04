<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Permisos de Usuarios
        Permission::create([
            'name'          => 'Listar usuarios',
            'slug'          => 'users_index',
            'description'   => 'Lista y navega todos los roles del sistema',
        ]);

        Permission::create([
            'name'          => 'Creación de usuarios',
            'slug'          => 'users_create',
            'description'   => 'Puede crear nuevos usuarios en el sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de usuario',
            'slug'          => 'users_show',
            'description'   => 'Ve detalle de cada usuario del sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de usuarios',
            'slug'          => 'users_edit',
            'description'   => 'Puede editar cualquier dato de un usuario del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar usuario',
            'slug'          => 'users_destroy',
            'description'   => 'Puede eliminar cualquier usuario del sistema',
        ]);

        //Permisos de Roles
        Permission::create([
            'name'          => 'Listar roles',
            'slug'          => 'roles_index',
            'description'   => 'Lista y navega todos los roles del sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de un rol',
            'slug'          => 'roles_show',
            'description'   => 'Ve detalle de cada rol del sistema',
        ]);

        Permission::create([
            'name'          => 'Creación de roles',
            'slug'          => 'roles_create',
            'description'   => 'Puede crear nuevos roles en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de roles',
            'slug'          => 'roles_edit',
            'description'   => 'Puede editar cualquier dato de un rol del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar roles',
            'slug'          => 'roles_destroy',
            'description'   => 'Puede eliminar cualquier rol del sistema',
        ]);


        //Permisos de Proveedores
        Permission::create([
            'name'          => 'Listar Proveedores',
            'slug'          => 'proveedores_index',
            'description'   => 'Lista y navega todos los proveedores del sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de un proveedor',
            'slug'          => 'proveedores_show',
            'description'   => 'Ve detalle de cada proveedor del sistema',
        ]);

        Permission::create([
            'name'          => 'Creación de proveedores',
            'slug'          => 'proveedores_create',
            'description'   => 'Puede crear nuevos proveedores en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de proveedores',
            'slug'          => 'proveedores_edit',
            'description'   => 'Puede editar cualquier dato de un proveedor del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar proveedores',
            'slug'          => 'proveedores_destroy',
            'description'   => 'Puede eliminar cualquier proveedor del sistema',
        ]);
    }
}
