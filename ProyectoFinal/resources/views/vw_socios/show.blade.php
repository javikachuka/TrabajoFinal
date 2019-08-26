@extends('layouts.app')

@section('content')
<h1>Socio</h1>
<form class="form-group"  method="POST" action="/socios">
    @csrf
    <div class="form-group">
        <h2>Datos Personales</h2>
        <label>Apellido</label>
        <input type="text" value="{{$socio->apellido}}" name="apellido" class="form-control" readonly>
        
        <label>Nombre</label>
        <input type="text" value="{{$socio->nombre}}" name="nombre" class="form-control" readonly>
        <label>Dni</label>
        <input type="text" value="{{$socio->dni}}" name="dni" class="form-control" readonly>
        <label>Nro De Conexion</label>
        <input type="text" value="{{$socio->nro_conexion}}" name="nro_conexion" class="form-control" readonly>
        <br>
        <h3>Domicilio</h3>
        <label for="">Barrio</label>
        <input type="text" value="{{$socio->domicilio->barrio->nombre}}" name="domicilio" class="form-control" readonly>
        <label>Calle</label>
        <input type="text" value="{{$socio->domicilio->calle}}"  name="calle" class="form-control" readonly>
        <label>Altura</label>
        <input type="text" value="{{$socio->domicilio->altura}}" name="altura" class="form-control" readonly>
             
    </div>
  
    <div class="text-right">
    <input type="reset" value="Editar" class="btn btn-secondary"  onclick="location.href='/socios/{{$socio->id}}/edit'">
    </div>
   

</form>
@endsection