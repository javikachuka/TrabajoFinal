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
            'description'   => 'Lista y navega todos los usuarios del sistema',
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

        //Permisos de permisos
        Permission::create([
            'name'          => 'Todos los permisos de permisos',
            'slug'          => 'permisos_all',
            'description'   => 'Puede realizar todos las acciones de permisos',
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


        //Permisos de Reclamos
        Permission::create([
            'name'          => 'Listar Reclamos',
            'slug'          => 'reclamos_index',
            'description'   => 'Lista y navega todos los reclamos del sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de un reclamo',
            'slug'          => 'reclamos_show',
            'description'   => 'Ve detalle de cada reclamo del sistema',
        ]);

        Permission::create([
            'name'          => 'Creación de reclamos',
            'slug'          => 'reclamos_create',
            'description'   => 'Puede crear nuevos reclamos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de reclamos',
            'slug'          => 'reclamos_edit',
            'description'   => 'Puede editar cualquier dato de un reclamo del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar Reclamo',
            'slug'          => 'reclamos_destroy',
            'description'   => 'Puede eliminar cualquier reclamo del sistema',
        ]);


        //Permisos de Tipos de Reclamos
        Permission::create([
            'name'          => 'Listar los tipos de reclamos',
            'slug'          => 'tipoReclamos_index',
            'description'   => 'Lista y navega todos los tipos de reclamos del sistema',
        ]);

        Permission::create([
            'name'          => 'Creación de tipoReclamos',
            'slug'          => 'tipoReclamos_create',
            'description'   => 'Puede crear nuevos tipos de Reclamos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de tipos de Reclamos',
            'slug'          => 'tipoReclamos_edit',
            'description'   => 'Puede editar cualquier dato de un tipo de reclamo del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar tipo de reclamo',
            'slug'          => 'tipoReclamos_destroy',
            'description'   => 'Puede eliminar cualquier tipo de reclamo del sistema',
        ]);


        //Permisos de Requisitos
        Permission::create([
            'name'          => 'Listar los requisitos',
            'slug'          => 'requisitos_index',
            'description'   => 'Lista y navega todos los requisitos del sistema',
        ]);

        Permission::create([
            'name'          => 'Creación de requisitos',
            'slug'          => 'requisitos_create',
            'description'   => 'Puede crear nuevos requisitos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de requisitos',
            'slug'          => 'requisitos_edit',
            'description'   => 'Puede editar cualquier requisito del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar requisito',
            'slug'          => 'requisitos_destroy',
            'description'   => 'Puede eliminar cualquier requisito del sistema',
        ]);

        //Permisos de Socios
        Permission::create([
            'name'          => 'Listar los socios',
            'slug'          => 'socios_index',
            'description'   => 'Lista y navega todos los socios del sistema',
        ]);

        Permission::create([
            'name'          => 'Creación de socios',
            'slug'          => 'socios_create',
            'description'   => 'Puede crear nuevos socios en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de socios',
            'slug'          => 'socios_edit',
            'description'   => 'Puede editar cualquier socio del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar socio',
            'slug'          => 'socios_destroy',
            'description'   => 'Puede eliminar cualquier socio del sistema',
        ]);


        //Permisos de Trabajos
        Permission::create([
            'name'          => 'Listar los trabajos',
            'slug'          => 'trabajos_index',
            'description'   => 'Lista y navega todos los trabajos del sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de trabajos',
            'slug'          => 'trabajos_show',
            'description'   => 'Puede ver detalles de trabajos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Asignacion de trabajos',
            'slug'          => 'trabajos_asignar',
            'description'   => 'Puede asignar un trabajo a cierto/s empleado/s  del sistema',
        ]);

        Permission::create([
            'name'          => 'Iniciar trabajo',
            'slug'          => 'trabajos_iniciar',
            'description'   => 'Puede iniciar cualquier trabajo del sistema',
        ]);

        Permission::create([
            'name'          => 'Finalizar trabajo',
            'slug'          => 'trabajos_finalizar',
            'description'   => 'Puede finalizar cualquier trabajo del sistema',
        ]);


        //Permisos de Movimientos
        Permission::create([
            'name'          => 'Listar los movimientos',
            'slug'          => 'movimientos_index',
            'description'   => 'Lista y navega todos los movimientos del sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de movimientos',
            'slug'          => 'movimientos_show',
            'description'   => 'Puede ver detalles de movimientos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Registro de un ingreso en movimientos',
            'slug'          => 'movimientos_ingreso',
            'description'   => 'Puede registrar un movimiento de tipo ingreso al sistema',
        ]);

        Permission::create([
            'name'          => 'Registro de una transferencia en movimientos',
            'slug'          => 'movimientos_transferencia',
            'description'   => 'Puede registrar un movimiento de tipo transferencia al sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar un movimiento',
            'slug'          => 'movimientos_destroy',
            'description'   => 'Puede eliminar cualquier movimiento del sistema',
        ]);

        //Permisos de Pedidos
        Permission::create([
            'name'          => 'Listar los pedidos',
            'slug'          => 'pedidos_index',
            'description'   => 'Lista y navega todos los pedidos del sistema',
        ]);

        Permission::create([
            'name'          => 'Creacion de pedidos',
            'slug'          => 'pedidos_create',
            'description'   => 'Puede registrar un pedido al sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de pedidos',
            'slug'          => 'pedidos_show',
            'description'   => 'Puede ver detalles de pedidos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edicion de pedidos',
            'slug'          => 'pedidos_edit',
            'description'   => 'Puede editar los pedidos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar un pedido',
            'slug'          => 'pedidos_destroy',
            'description'   => 'Puede eliminar cualquier pedido del sistema',
        ]);


        //Permisos de Productos
        Permission::create([
            'name'          => 'Listar los productos',
            'slug'          => 'productos_index',
            'description'   => 'Lista y navega todos los productos del sistema',
        ]);

        Permission::create([
            'name'          => 'Creacion de productos',
            'slug'          => 'productos_create',
            'description'   => 'Puede registrar un producto al sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de productos',
            'slug'          => 'productos_show',
            'description'   => 'Puede ver detalles de productos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edicion de productos',
            'slug'          => 'productos_edit',
            'description'   => 'Puede editar los productos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar un producto',
            'slug'          => 'productos_destroy',
            'description'   => 'Puede eliminar cualquier producto del sistema',
        ]);


        //Permisos de Rubros
        Permission::create([
            'name'          => 'Listar los rubros',
            'slug'          => 'rubros_index',
            'description'   => 'Lista y navega todos los rubros del sistema',
        ]);

        Permission::create([
            'name'          => 'Creacion de rubros',
            'slug'          => 'rubros_create',
            'description'   => 'Puede registrar un rubro al sistema',
        ]);

        Permission::create([
            'name'          => 'Edicion de rubros',
            'slug'          => 'rubros_edit',
            'description'   => 'Puede editar los rubros en el sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar un rubro',
            'slug'          => 'rubros_destroy',
            'description'   => 'Puede eliminar cualquier rubro del sistema',
        ]);


        //Permisos de Almacenes
        Permission::create([
            'name'          => 'Listar los almacenes',
            'slug'          => 'almacenes_index',
            'description'   => 'Lista y navega todos los almacenes del sistema',
        ]);

        Permission::create([
            'name'          => 'Creacion de almacenes',
            'slug'          => 'almacenes_create',
            'description'   => 'Puede registrar un almacen al sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de almacenes',
            'slug'          => 'almacenes_show',
            'description'   => 'Puede ver detalles de almacenes en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edicion de almacenes',
            'slug'          => 'almacenes_edit',
            'description'   => 'Puede editar los almacenes en el sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar un almacen',
            'slug'          => 'almacenes_destroy',
            'description'   => 'Puede eliminar cualquier almacen del sistema',
        ]);

        //Permisos de Asistencias
        Permission::create([
            'name'          => 'Creacion de asistencias',
            'slug'          => 'asistencias_create',
            'description'   => 'Puede registrar una asistencia al sistema',
        ]);

        Permission::create([
            'name'          => 'Listar las asistencias',
            'slug'          => 'asistencias_show',
            'description'   => 'Lista y navega todos las asistencias del sistema',
        ]);

        //Permisos de Turnos
        Permission::create([
            'name'          => 'Todos los permisos de turnos',
            'slug'          => 'turnos_all',
            'description'   => 'Puede realizar todos las acciones de turnos',
        ]);

        //Permisos de Horarios
        Permission::create([
            'name'          => 'Todos los permisos de horarios',
            'slug'          => 'horarios_all',
            'description'   => 'Puede realizar todos las acciones de horarios',
        ]);

        //Permisos de Flujo de Trabajo
        Permission::create([
            'name'          => 'Listar los flujos de Trabajos',
            'slug'          => 'flujoTrabajos_index',
            'description'   => 'Lista y navega todos los flujos de Trabajos del sistema',
        ]);

        Permission::create([
            'name'          => 'Creacion de flujos de Trabajos',
            'slug'          => 'flujoTrabajos_create',
            'description'   => 'Puede registrar un flujo al sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de flujos de Trabajos',
            'slug'          => 'flujoTrabajos_show',
            'description'   => 'Puede ver detalles de flujo de Trabajos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edicion de flujo de Trabajos',
            'slug'          => 'flujoTrabajos_edit',
            'description'   => 'Puede editar los flujos de Trabajos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar un flujo',
            'slug'          => 'flujoTrabajos_destroy',
            'description'   => 'Puede eliminar cualquier flujo de trabajo del sistema',
        ]);

        //Permisos de Estados
        Permission::create([
            'name'          => 'Todos los permisos de estados',
            'slug'          => 'estados_all',
            'description'   => 'Puede realizar todos las acciones de estados',
        ]);

        //Permisos de Auditoria
        Permission::create([
            'name'          => 'Todos los permisos de auditoria',
            'slug'          => 'auditoria_all',
            'description'   => 'Puede realizar todos las acciones de auditoria',
        ]);

        //Permisos de Configuracion
        Permission::create([
            'name'          => 'Todos los permisos de configuracion',
            'slug'          => 'configuracion_all',
            'description'   => 'Puede realizar todos las acciones de configuracion',
        ]);

    }
}
