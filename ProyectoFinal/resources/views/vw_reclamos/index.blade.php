@extends('layouts.app')

@section('title','Reclamos')

@section('content')
	<h1>Reclamos</h1>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-3">
				<select class="form-control">
					<option value="0" selected>Seleccione un socio</option>
					@foreach($socios as $socio)
						<option >{{$socio->apellido . ' ' . $socio->nombre}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-3">
				<select class="form-control">
					<option value="0" selected>Seleccione un reclamo</option>
					@foreach($reclamos as $reclamo)
						<option >{{$reclamo->nombre}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<br>
		<div class="row">
				<div class="col-sm-3">
					<select class="form-control">
						<option value="0" selected>Seleccione un tipo</option>
						@foreach($tip_rec as $tipo_reclamo)
							<option >{{$tipo_reclamo->nombre}}</option>
						@endforeach
					</select>
				</div>
		</div>
	</div>
	
		

	<div class="text-right">
		<button type="submit" class="btn btn-primary " onclick="location.href = '{{ action('ReclamoController@create') }}'">Nuevo Reclamo</button>
	</div>
	<br>
	<h2>Listado de Reclamos</h2>
	<table class="table table-striped">
	    <thead>
	      <tr>
	        <th>Id Reclamo</th>
	        <th>Reclamo</th>
	        <th>Descripcion</th>
	      </tr>
	    </thead>
	    <tbody>
	    	@foreach($reclamos as $reclamo)
	    		<tr>
	        		<td>{{$reclamo->id}}</td>
	        		<td>{{$reclamo->nombre}}</td>
	        		<td>{{$reclamo->descripcion}}</td>
	      	</tr>

	      @endforeach
	    </tbody>
	</table>
	
@endsection