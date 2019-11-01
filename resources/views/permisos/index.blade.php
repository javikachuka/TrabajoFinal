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
                        <th>Nombre</th>
                        <th>Slug</th>
                        <th>Descripcion</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permisos as $permiso)

                    <tr>
                        <td>{{$permiso->name}}</td>
                        <td>{{$permiso->slug}}</td>
                        <td>{{$permiso->description}}</td>
                        <td width="200px">
                            <a href="{{ route('permisos.edit', $permiso) }}" class="btn btn-xs btn-secondary"> Editar
                            </a>
                            <form method="POST" action="permisos/{{$permiso}}"
                                onsubmit="return confirm('Desea borrar el permiso {{$permiso->name}} ?')"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <input value="Borrar" type="submit" class="btn btn-sm btn-danger btn-xs btn-delete">
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
@endpush
