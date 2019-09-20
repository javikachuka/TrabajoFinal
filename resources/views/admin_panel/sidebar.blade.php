<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-primary">
        <!-- Brand Logo -->
        <a href="/home" class="brand-link">
          {{-- <img src="" alt="Coop Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
          <span class="brand-text font-weight-bold align-content-center">ReCoop</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{asset('admin_panel/dist/img/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="{{ route('users.show' , auth()->user()->id) }}" class="d-block">{{ auth()->user()->name }}</a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->


                <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fal fa-clipboard-list"></i>
                        <p>
                          Gestion de Reclamos
                          <i class="right fal fa-angle-left"></i>
                        </p>
                      </a>

                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                              <a href="{{ route('reclamos.index') }}" class="nav-link">
                                <i class="fal fa-clipboard nav-icon"></i>
                                <p>Reclamos</p>
                              </a>
                        </li>
                        <li class="nav-item">
                              <a href="{{ route('tipoReclamos.index') }}" class="nav-link">
                                <i class="fal fa-list nav-icon"></i>
                                <p>Tipos de Reclamos</p>
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
                            <li class="nav-item">
                                  <a href="{{ route('trabajos.index') }}" class="nav-link">
                                    <i class="fal fa-user-hard-hat nav-icon"></i>
                                    <p>Trabajos</p>
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
                            <li class="nav-item">
                                <a href="{{ route('movimientos.index') }}" class="nav-link">
                                    <i class="fal fa-dolly nav-icon"></i>
                                    <p>Movimientos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('productos.index') }}" class="nav-link">
                                    <i class="fal fa-cube nav-icon"></i>
                                    <p>Productos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('proveedores.index') }}" class="nav-link">
                                    <i class="fal fa-people-carry nav-icon"></i>
                                    <p>Proveedores</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('almacenes.index') }}" class="nav-link">
                                    <i class="fad fa-warehouse nav-icon"></i>
                                    <p>Almacenes</p>
                                </a>
                            </li>
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
                        <li class="nav-item">
                          <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="fal fa-tasks nav-icon"></i>
                            <p>Asistencias</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{ route('roles.index') }}" class="nav-link">
                            <i class="fal fa-user-lock nav-icon"></i>
                            <p>Roles</p>
                          </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{route('permisos.index')}}" class="nav-link">
                            <i class="fal fa-user-tag nav-icon"></i>
                            <p>Permisos</p>
                          </a>
                        </li>
                      </ul>
              </li>
              <li class="nav-item has-treeview ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fad fa-project-diagram "></i>
                    <p>
                      Gestion de WorkFlow
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
                    <li class="nav-item">
                          <a href="{{ route('estados.index') }}" class="nav-link">
                            <i class="fal fa-shield-alt nav-icon"></i>
                            <p>Estados</p>
                          </a>
                    </li>
                   </ul>


                </li>

              <li class="nav-item has-treeview ">
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
                  </li>






            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
