@extends('layouts.app')

@section('title','Carga')

@section('content')
	<form class="form-group " method="POST" action="/empleados" >
		@csrf
		<div class="form-group">
			<label>Nombre</label>
			<input type="text" name="nombre" class="form-control">

			<label>Apellido</label>
			<input type="text" name="apellido" class="form-control">
		</div>
		<div class="text-right">
			<button type="submit" class="btn btn-success">Guardar</button>
		</div>
	</form>

@endsection

