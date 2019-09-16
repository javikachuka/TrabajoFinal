@extends('admin_panel.index')


@section('content')
    <h1>Listado de Usuarios</h1>
    <div class="text-left form-group">
            <button type="submit" class="btn btn-primary " onclick="location.href = '{{ route('users.create') }}'">Registrar Empleado</button>
    </div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="users" class="table table-bordered table-striped table-hover datatable">
                <thead>
                  <tr>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Roles</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $user)

                        <tr>
                            <td>{{$user->apellido}}</td>
                            <td>{{$user->name}}</td>
                            <td>
                                @foreach ($user->roles as $rol)
                                    <span class="badge badge-info">{{$rol->name}}</span>
                                @endforeach
                            </td>
                            <td width ="200px">
                                <form method="POST" action="users/{{$user->id}}">
                                    @can('users_edit')
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-xs btn-secondary"> Editar </a>
                                    @endcan
                                    @csrf
                                    @method('DELETE')
                                    @can('users_destroy')
                                        <button type="submit" class="btn btn-danger btn-xs btn-delete">Borrar</button>
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
          $('#users').DataTable({
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
        @if(session('confirmar'))
            Confirmar.fire() ;
        @elseif(session('cancelar'))
            Cancelar.fire();
        @endif
    </script>
@endpush
