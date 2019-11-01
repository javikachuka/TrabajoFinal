@extends('admin_panel.index')

@section('content')


<div class="card">
    <div class="card-header">
        <h3>Listado de Roles
            @can('roles_create')
            <button type="submit" class="btn btn-primary btn-xs"
                onclick="location.href = '{{ route('roles.create') }}'">Crear Rol</button>
            @endcan
        </h3>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="proveedores" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Permisos</th>
                        <th>Permiso Especial</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $rol)

                    <tr>
                        <td>{{$rol->id}}</td>
                        <td>{{$rol->name}}</td>
                        <td width="250px">{{$rol->description}}</td>
                        <td>
                            @foreach ($rol->permissions as $permiso)
                            <span class="badge badge-info">{{$permiso->name}}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($rol->special == null)
                            <span class="badge badge-warning">No posee</span>
                            @else
                            <span class="badge badge-info">{{$rol->special}}</span>
                            @endif
                        </td>
                        <td width="150px">
                            @can('roles_edit')
                            <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-xs btn-secondary">
                                Editar </a>
                            @endcan

                            @can('roles_destroy')
                            <form id="form-borrar{{$rol->id}}" method="POST"
                                action="{{route('roles.destroy' , $rol->id)}}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs btn-almacen"
                                    id="{{$rol->id}}">Borrar</button>
                            </form>
                            @endcan
                        </td>
                    </tr>

                    @endforeach
                    {{-- {{$proveedores->links()}} --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(function () {
          $('#proveedores').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
          });
        });
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
