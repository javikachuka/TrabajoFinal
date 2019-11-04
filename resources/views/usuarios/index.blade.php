@extends('admin_panel.index')


@section('content')
<div class="text-left form-group">
</div>
<div class="card">
    <div class="card-header">
        <h3>Listado de Empleados
            @can('users_create')
            <button type="submit" class="btn btn-primary btn-xs"
                onclick="location.href = '{{ route('users.create') }}'">Registrar Empleado</button>
            @endcan
        </h3>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="users" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Perfil</th>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Roles</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $user)

                    <tr>
                        @if($user->urlFoto != null)
                        <td style="text-align: center"><img src="{{asset('img/perfiles'.$user->urlFoto)}}" alt=""
                                class="table-avatar"></td>
                        @else
                        <div class="d-flex justify-content-center">
                            <td width="10%"><img src="{{asset('img/perfiles/usuario-sin-foto.png')}}" alt="" width="25"
                                    height="25" class="table-avatar"></td>

                        </div>
                        @endif
                        <td>{{$user->apellido}}</td>
                        <td>{{$user->name}}</td>
                        <td style="text-align: right">{{$user->dni}}</td>
                        <td>
                            @foreach ($user->roles as $rol)
                            <span class="badge badge-info">{{$rol->name}}</span>
                            @endforeach
                        </td>
                        <td width="13%">
                            @can('users_show')
                            <a href="{{ route('users.show', $user) }}" class="btn btn-xs btn-primary"> Ver mas
                            </a>
                            @endcan
                            @can('users_edit')
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-xs btn-secondary"> Editar
                            </a>
                            @endcan
                            @can('users_destroy')
                            <form id="form-borrar{{$user->id}}" method="POST"
                                action="{{route('users.destroy' , $user->id)}}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs btn-almacen"
                                    id="{{$user->id}}">Borrar</button>
                            </form>
                            @endcan
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(function () {
          $('#users').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "columnDefs": [
                {"className": "dt-body-left", "targets": [0]}
            ],
            language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
          });
        });
</script>
<script>
    @if(session('confirmar'))
            Confirmar.fire() ;
        @elseif(session('cancelar'))
            Cancelar.fire();
        @elseif(session('borrado'))
            Borrado.fire();
        @endif
</script>

<script>
    $('.btn-almacen').on('click', function(e){
                                var id = $(this).attr('id');
                            e.preventDefault();

                        swal({
                                title: "Cuidado!",
                                text: "Esta seguro que desea eliminar?",
                                icon: "warning",
                                dangerMode: true,

                                buttons: {
                                cancel: "Cancelar",
                                confirm: "Aceptar",
                                },
                            })
                            .then ((willDelete) => {
                                if (willDelete) {
                                $("#form-borrar"+id).submit();
                                }
                            });
                         });
</script>
@endpush
