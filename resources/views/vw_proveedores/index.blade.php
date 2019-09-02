@extends('layouts.app')

@section('content')

<h1>Listado de Proveedores</h1>

    <div class="form-group col-md-8">
        <button type="submit" class="btn btn-primary " onclick="location.href = '{{ route('proveedores.create') }}'">Registrar Proveedor</button>
    </div>
    <div class="form-group text-right">
    <form method="GET" action="/search">
    <input type="search" name="search" class="" value="{{ old('search') }}">
            <button type="submit" class="btn btn-primary">Buscar</button>

        </form>
    </div>



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
                    <form method="POST" action="proveedores/{{$proveedor->id}}">
                        <button type="button" class="btn btn-sm btn-secondary" onclick="location.href='{{route('proveedores.edit',$proveedor->id)}}'">Editar</button>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger btn-xs btn-delete">Borrar</button>
                    </form>
                </td>
              </tr>

          @endforeach
          {{-- {{$proveedores->links()}} --}}
    </tbody>
</table>


@endsection
