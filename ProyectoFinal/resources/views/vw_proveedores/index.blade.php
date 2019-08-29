@extends('layouts.app')

@section('content')

<h1>Listado de Proveedores</h1>
<table class="table table-striped">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>CUIT</th>
        <th>Email</th>
        <th>Telefono</th>
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>
        @foreach($proveedores as $prov)

            <tr>
                <td>{{$prov->nombre}}</td>
                <td>{{$prov->cuit}}</td>
                <td>{{$prov->email}}</td>
                <td>{{$prov->telefono}}</td>
                <td width ="200px">
                <button type="button" class="btn btn-info" onclick="location.href='{{route('proveedores.edit',$user->id)}}'">Editar</button>
                <form method="POST" action="users/{{$prov->id}}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-xs btn-delete">Borrar</button>
                </form>
                </td>
              </tr>

          @endforeach
    </tbody>
</table>
  <div class="text-right">
    <button type="submit" class="btn btn-primary " onclick="location.href = '{{ route('proveedores.create') }}'">Registrar Proveedor</button>
  </div>


@endsection
