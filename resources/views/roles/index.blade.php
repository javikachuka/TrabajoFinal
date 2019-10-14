@extends('admin_panel.index')

@section('content')


<div class="card">
    <div class="card-header">
        <h3>Listado de Roles
            <button type="submit" class="btn btn-primary btn-xs" onclick="location.href = '{{ route('roles.create') }}'">Crear Rol</button>
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
                                <td width ="150px">
                                    <form method="POST" action="roles/{{$rol->id}}">
                                        @can('roles_edit')
                                            <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-sm btn-xs btn-secondary"> Editar </a>
                                        @endcan
                                        @csrf
                                        @method('DELETE')
                                        @can('roles_destroy')
                                            <button type="submit" class="btn btn-sm btn-danger btn-xs btn-delete">Borrar</button>
                                        @endcan
                                    </form>
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
@endpush
