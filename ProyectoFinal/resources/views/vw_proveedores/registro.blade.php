@extends('vw_proveedores.form')


@section('estructura')
<h1>Registro de Proveedores</h1>
<form class="form-group" method="POST" action="/proveedores">
    @csrf
    @section('formulario')
    @endsection
    <div class="text-right">
        <button type="submit" class="btn btn-success">Guardar</button>
        <input type="reset" value="Limpiar" class="btn btn-secondary">
    </div>
</form>

@endsection
