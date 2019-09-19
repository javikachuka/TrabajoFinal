@extends('admin_panel.index')

@section('content')

<h1>Listado de Permisos</h1>

    <div class="form-group col-md-8">
        <button type="submit" class="btn btn-primary " onclick="location.href = '{{ route('permisos.create') }}'">Nuevo Permiso</button>
    </div>
<div class="card">
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
                            <td width ="200px">
                                @can('permisos_edit')
                                    <a href="{{ route('permisos.edit', $permiso) }}" class="btn btn-xs btn-secondary"> Editar </a>
                                @endcan
                            <form method="POST" action="permisos/{{$permiso}}" onsubmit="return confirm('Desea borrar el permiso {{$permiso->name}} ?')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    @can('permisos_destroy')
                                        <input value="Borrar" type="submit" class="btn btn-sm btn-danger btn-xs btn-delete">
                                    @endcan
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
