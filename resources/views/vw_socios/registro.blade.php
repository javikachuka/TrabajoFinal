@extends('layouts.app') 

@section('content')
    <h1>Registro de Socios</h1>
    <form class="form-group"  method="POST" action="/socios">
        @csrf
        <div class="form-group">
            <h2>Datos Personales</h2>
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" placeholder="Ingrese el apellido">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre">
            <label>DNI</label>
            <input type="text" name="dni" class="form-control" placeholder="Ingrese el dni">
            <label>Nro De Conexion</label>
            <input type="text" name="nro_conexion" class="form-control" placeholder="Ingrese el nro de conexion de socio">
            <br>
            <h3>Domicilio</h3>
            
            <label>Calle</label>
            <input type="text" name="calle" class="form-control" placeholder="Ingrese el nombre de la calle">
            <label>Altura</label>
            <input type="text" name="altura" class="form-control" placeholder="Ingrese la altura">
            <label for="">Barrio</label>
            <select name="domicilio" class="form-control" >
                <option value="0" selected>--Seleccione un barrio--</option>
                    @foreach ($barrios as $barrio)
                        <option value="{{$barrio->id}}">{{$barrio->nombre}}</option>
                    @endforeach
            </select>
            <br>
            {{-- <div class="form-inline">
                <label>Calle</label>
                <input type="text" name="calle" class="form-control">
                <label>Altura</label>
                <input type="text" name="altura" class="form-control">
            </div> --}}
            
        </div>
      
        <div class="text-right">
            <input type="reset" value="Limpiar" class="btn btn-secondary">
            <input type="submit" value="Cargar Socio" class="btn btn-success">
        </div>
       

    </form>
@endsection