@extends('layouts.app')

@section('title','Listado de Empleados')

@section('content')
	<h1>Listado de Usuarios</h1>
	<table class="table table-striped">
	    <thead>
	      <tr>
	        <th>Apellido</th>
			<th>Nombre</th>
			<th>Accion</th>
	      </tr>
	    </thead>
	    <tbody>
	    	@foreach($usuarios as $user)

	    		<tr>
	        		<td>{{$user->apellido}}</td>
					<td>{{$user->name}}</td>
					<td width ="200px">
					<form method="POST" action="users/{{$user}}">
						@method('delete')
						@csrf
						<button type="button" class="btn btn-info" onclick="location.href='{{route('users.edit',$user->id)}}'">Editar</button> 
						<button type="submit" class="btn btn-danger btn-xs btn-delete" onclick="location.href='{{route('users.destroy',$user->id)}}'">Borrar</button>
						
					</form>

					</td>
	      		</tr>

	      	@endforeach
	    </tbody>
	</table>
  	<div class="text-right">
		<button type="submit" class="btn btn-primary " onclick="location.href = '{{ route('users.create') }}'">Registrar Empleado</button>
  	</div>


@endsection
