@extends('vw_proveedores.form')

@section('estructura')
	<h1>Edicion de Proveedores</h1>
    <form class="form-group " method="POST" action="/proveedores/{{$proveedor->id}}" >
        @method('PUT')
        @csrf
        @section('formulario')
        @endsection
        @section('botones')
        <div class="text-right">
                <input type="reset" value="Limpiar" class="btn btn-secondary">
                <button type="submit" class="btn btn-success">Modificar</button>
        </div>
        @endsection



	</form>

@endsection
