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
        @foreach($proveedores as $proveedor)

            <tr>
                <td>{{$proveedor->nombre}}</td>
                <td>{{$proveedor->cuit}}</td>
                <td>{{$proveedor->email}}</td>
                <td>{{$proveedor->telefono}}</td>
                <td width ="200px">
                <button type="button" class="btn btn-info" onclick="location.href='{{route('proveedores.edit',$proveedor->id)}}'">Editar</button>
                <form method="POST" action="proveedores/{{$proveedor->id}}">
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
