@extends('vw_usuarios.form')

@section('estructura')
	<h1>Registro de Usuarios</h1>
	<form class="form-group " method="POST" action="/users" >
		@csrf
		@section('formulario')
		@endsection
		@section('botones')
		<div class="text-right">
				<input type="reset" value="Limpiar" class="btn btn-secondary">
				<button type="submit" class="btn btn-success">Guardar</button>
		</div>
		@endsection
		
	</form>
	
@endsection
	



