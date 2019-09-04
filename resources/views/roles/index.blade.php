@extends('admin_panel.index')

@section('content')

<h1>Listado de Roles</h1>

    <div class="form-group col-md-8">
        <button type="submit" class="btn btn-primary " onclick="location.href = '{{ route('roles.create') }}'">Crear Rol</button>
    </div>
    <div class="form-group text-right">
    <form method="GET" action="#">
    <input type="search" name="search" class="" value="{{ old('search') }}">
            <button type="submit" class="btn btn-primary">Buscar</button>

        </form>
    </div>



<table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>
        @foreach($roles as $rol)

            <tr>
                <td>{{$rol->id}}</td>
                <td>{{$rol->name}}</td>
                <td>{{$rol->description}}</td>
                <td width ="200px">
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


@endsection
