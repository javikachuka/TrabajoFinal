@extends('admin_panel.index')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Listado de Permisos
            <button type="submit" class="btn btn-primary btn-xs"
                onclick="location.href = '{{ route('permisos.create') }}'">Nuevo
                Permiso</button>
        </h3>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="permisos" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Slug</th>
                        <th>Descripcion</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permisos as $permiso)

                    <tr>
                        <td>{{$permiso->id}}</td>
                        <td>{{$permiso->name}}</td>
                        <td>{{$permiso->slug}}</td>
                        <td>{{$permiso->description}}</td>
                        <td width="200px">
                            <a href="{{ route('permisos.edit', $permiso) }}" class="btn btn-xs btn-secondary"> Editar
                            </a>
                            <form id="form-borrar{{$permiso->id}}" method="POST"
                                action="{{route('permisos.destroy' , $permiso->id)}}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs btn-almacen"
                                    id="{{$permiso->id}}">Borrar</button>
                            </form>
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
          $('#permisos').DataTable({
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
