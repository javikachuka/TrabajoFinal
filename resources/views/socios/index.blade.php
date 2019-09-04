@extends('layouts.app') 

@section('content')
    <h1>Listado de Socios</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Nro de Conexion</th>
                <th>Direccion</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($socios as $socio)
                <tr>
                    <td>{{$socio->apellido}}</td>
                    <td>{{$socio->nombre}}</td>
                    <td>{{$socio->dni}}</td>
                    <td>{{$socio->nro_conexion}}</td>
                    
                    <td>{{$socio->domicilio->barrio->nombre}}</td>
                        
                    <td><button type="button" class="btn btn-outline-info" onclick="location.href='/socios/{{$socio->id}}'">+</button> </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    

    <div class="text-right">
		<button type="submit" class="btn btn-primary " onclick="location.href = '{{ action('SocioController@create') }}'">Registrar Socio</button>
  	</div>
@endsection