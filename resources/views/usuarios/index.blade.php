@extends('admin_panel.index')


@section('content')
    <div class="text-left form-group">
    </div>
<div class="card">
    <div class="card-header">
        <h3>Listado de Empleados
            <button type="submit" class="btn btn-primary btn-xs" onclick="location.href = '{{ route('users.create') }}'">Registrar Empleado</button>
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
                                <td><img src="{{asset('img/perfiles'.$user->urlFoto)}}" alt="" class="table-avatar"></td>
                            @else
                                <div class="d-flex justify-content-center">
                                    <td width="10%"><img src="{{asset('img/perfiles/usuario-sin-foto.png')}}" alt="" width="25" height="25" class="table-avatar"></td>

                                </div>
                            @endif
                            <td>{{$user->apellido}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->dni}}</td>
                            <td>
                                @foreach ($user->roles as $rol)
                                    <span class="badge badge-info">{{$rol->name}}</span>
                                @endforeach
                            </td>
                            <td width ="13%">
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
            "columnDefs": [
                {"className": "dt-body-left", "targets": [0]}
            ],
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
@endpush
