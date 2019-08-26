@extends('layouts.app')

@section('title','Listado de Empleados')

@section('content')
	<h1>Listado de Empleados</h1>
	<table class="table table-striped">
	    <thead>
	      <tr>
	        <th>Apellido</th>
	        <th>Nombre</th>
	      </tr>
	    </thead>
	    <tbody>
	    	@foreach($empleados as $empleado)

	    		<tr>
	        		<td>{{$empleado->apellido}}</td>
	        		<td>{{$empleado->nombre}}</td>
	      		</tr>

	      	@endforeach
	    </tbody>
	</table>
  	<div class="text-right">
		<button type="submit" class="btn btn-primary " onclick="location.href = '{{ action('EmpleadoController@create') }}'">Registrar Empleado</button>
  	</div>


@endsection
