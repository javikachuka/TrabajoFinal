@extends('layouts.app')

@section('content')
@yield('estructura')
<div class="container">
    @yield('formulario')
    <h2>Datos del Proveedor</h2>
    <label>Nombre</label>
    <input type="text" name="name" class="form-control">
    <label>CUIT</label>
    <input type="text" name="cuit" class="form-control">
    <label>Email</label>
    <input type="text" name="Email" class="form-control">
    <label>Telefono</label>
    <input type="text" name="telefono" class="form-control">
    <input type="reset" value="Limpiar" class="btn btn-secondary">
</div>

@endsection
