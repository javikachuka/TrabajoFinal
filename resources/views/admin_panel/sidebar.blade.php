<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
        <img src="{{ asset('img/logo4.png')}}" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold align-content-center">ReCoop</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (auth()->user()->urlFoto != null)

                <img src="{{ asset('img/perfiles/'.auth()->user()->urlFoto) }}" class="img-circle elevation-2"
                    alt="User Image">
                @else
                <img src="{{ asset('img/perfiles/usuario-sin-foto.png')}}" class="img-circle elevation-2"
                    alt="User Image">

                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('inicio')}}" class="nav-link">
                        <i class="fal fa-home nav-icon"></i>
                        <p>Inicio</p>
                    </a>
                </li>

                <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fal fa-clipboard-list"></i>
                        <p>
                            Gestion de Reclamos
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @can('reclamos_index')
                        <li class="nav-item">
                            <a href="{{ route('reclamos.index') }}" class="nav-link">
                                <i class="fal fa-clipboard nav-icon"></i>
                                <p>Reclamos</p>
                            </a>
                        </li>
                        @endcan
                        @can('tipoReclamos_index')
                        <li class="nav-item">
                            <a href="{{ route('tipoReclamos.index') }}" class="nav-link">
                                <i class="fal fa-list nav-icon"></i>
                                <p>Tipos de Reclamos</p>
                            </a>
                        </li>
                        @endcan
                        @can('requisitos_index')
                        <li class="nav-item">
                            <a href="{{ route('requisitos.index') }}" class="nav-link">
                                <i class="fal fa-file-alt nav-icon"></i>
                                <p>Requisitos</p>
                            </a>
                        </li>
                        @endcan
                        @can('socios_index')
                        <li class="nav-item">
                            <a href="{{ route('socios.index') }}" class="nav-link">
                                <i class="fal fa-users nav-icon"></i>
                                <p>Socios</p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('estadistica.reclamos') }}" class="nav-link">
                                <i class="fal fa-chart-pie nav-icon"></i>
                                <p>Estadistica</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fal fa-forklift"></i>
                        <p>
                            Gestion de Trabajos
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @can('trabajos_index')
                        <li class="nav-item">
                            <a href="{{ route('trabajos.index') }}" class="nav-link">
                                <i class="fal fa-user-hard-hat nav-icon"></i>
                                <p>Trabajos</p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('estadistica.trabajos') }}" class="nav-link">
                                <i class="fal fa-chart-pie nav-icon"></i>
                                <p>Estadistica</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fal fa-warehouse"></i>
                        <p>
                            Gestion de Almacen
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @can('movimientos_index')
                        <li class="nav-item">
                            <a href="{{ route('movimientos.index') }}" class="nav-link">
                                <i class="fal fa-dolly nav-icon"></i>
                                <p>Movimientos</p>
                            </a>
                        </li>
                        @endcan
                        @can('pedidos_index')
                        <li class="nav-item">
                            <a href="{{ route('pedidos.index') }}" class="nav-link">
                                <i class="fal fa-cart-plus nav-icon"></i>
                                <p>Pedidos</p>
                            </a>
                        </li>
                        @endcan
                        @can('productos_index')
                        <li class="nav-item">
                            <a href="{{ route('productos.index') }}" class="nav-link">
                                <i class="fal fa-cube nav-icon"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                        @endcan
                        @can('rubros_index')
                        <li class="nav-item">
                            <a href="{{ route('rubros.index') }}" class="nav-link">
                                <i class="fal fa-cubes nav-icon"></i>
                                <p>Rubros</p>
                            </a>
                        </li>
                        @endcan
                        @can('proveedores_index')
                        <li class="nav-item">
                            <a href="{{ route('proveedores.index') }}" class="nav-link">
                                <i class="fal fa-people-carry nav-icon"></i>
                                <p>Proveedores</p>
                            </a>
                        </li>
                        @endcan
                        @can('almacenes_index')
                        <li class="nav-item">
                            <a href="{{ route('almacenes.index') }}" class="nav-link">
                                <i class="fad fa-warehouse nav-icon"></i>
                                <p>Almacenes</p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('estadistica.almacenes') }}" class="nav-link">
                                <i class="fal fa-chart-pie nav-icon"></i>
                                <p>Estadistica</p>
                            </a>
                        </li>
                    </ul>

                </li>

                <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fal fa-tasks"></i>
                        <p>
                            Gestion de Asistencias
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @can('asistencias_create')
                        <li class="nav-item">
                            <a href="{{ route('asistencias.index') }}" class="nav-link">
                                <i class="fal fa-user-check nav-icon"></i>
                                <p>Entradas y Salidas</p>
                            </a>
                        </li>
                        @endcan
                        @can('asistencias_show')
                        <li class="nav-item">
                            <a href="{{ route('asistencias.control') }}" class="nav-link">
                                <i class="fal fa-calendar-check nav-icon"></i>
                                <p>Control de Asistencias</p>
                            </a>
                        </li>
                        @endcan
                        @can('turnos_all')
                        <li class="nav-item">
                            <a href="{{ route('turnos.index') }}" class="nav-link">
                                <i class="fal fa-tasks nav-icon"></i>
                                <p>Turnos</p>
                            </a>
                        </li>
                        @endcan
                        @can('horarios_all')
                        <li class="nav-item">
                            <a href="{{ route('horarios.index') }}" class="nav-link">
                                <i class="fal fa-clock nav-icon"></i>
                                <p>Horarios</p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>

                <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fal fa-users-cog"></i>
                        <p>
                            Gestion Empleados
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @can('users_index')
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="fal fa-user nav-icon"></i>
                                <p>Empleados</p>
                            </a>
                        </li>
                        @endcan
                        @can('roles_index')
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link">
                                <i class="fal fa-user-lock nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        @endcan
                        @can('permisos_all')
                        <li class="nav-item">
                            <a href="{{route('permisos.index')}}" class="nav-link">
                                <i class="fal fa-user-tag nav-icon"></i>
                                <p>Permisos</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @can('flujoTrabajos_index')
                <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fad fa-project-diagram "></i>
                        <p>
                            Gestion de Flujos
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('flujoTrabajos.index') }}" class="nav-link">
                                <i class="fal fa-project-diagram nav-icon"></i>
                                <p>Flujos de Trabajo</p>
                            </a>
                        </li>
                        @can('estados_all')
                        <li class="nav-item">
                            <a href="{{ route('estados.index') }}" class="nav-link">
                                <i class="fal fa-shield-alt nav-icon"></i>
                                <p>Estados</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fal fa-file-pdf"></i>
                        <p>
                            Reportes
                            <i class="right fal fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('proveedor.pdf') }}" class="nav-link">
                <i class="fal fa-people-carry nav-icon"></i>
                <p>Proveedores</p>
                </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('movimientos.pdf') }}" class="nav-link">
                        <i class="fal fa-dolly nav-icon"></i>
                        <p>Movimientos</p>
                    </a>
                </li>

            </ul>
            </li> --}}
            @can('auditoria_all')
            <li class="nav-item">
                <a href="{{route('auditoria.index')}}" class="nav-link">
                    <i class="fal fa-search nav-icon"></i>
                    <p>Auditoria</p>
                </a>
            </li>
            @endcan
            @can('configuracion_all')
            <li class="nav-item">
                <a href="{{route('configuraciones.index')}}" class="nav-link">
                    <i class="fal fa-cogs nav-icon"></i>
                    <p>Configuracion</p>
                </a>
            </li>
            @endcan




            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
