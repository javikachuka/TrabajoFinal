@extends('layouts.app') 

@section('content')
    <h1>Edicion de Socios</h1>
    <form class="form-group"  method="POST" action="/socios/{{$socio->id}}">
        @method('PUT')
        @csrf
        <div class="form-group">
            <h2>Datos Personales</h2>
            <label>Apellido</label>
            <input type="text" value="{{$socio->apellido}}" name="apellido" class="form-control" placeholder="Ingrese el apellido">
            <label>Nombre</label>
            <input type="text" value="{{$socio->nombre}}" name="nombre" class="form-control" placeholder="Ingrese el nombre">
            <label>DNI</label>
            <input type="text" value="{{$socio->dni}}" name="dni" class="form-control" placeholder="Ingrese el dni">
            <label>Nro De Conexion</label>
            <input type="text" value="{{$socio->nro_conexion}}" name="nro_conexion" class="form-control" placeholder="Ingrese el nro de conexion de socio">
            <br>
            <h3>Domicilio</h3>
            <label for="">Barrio</label>
            <select name="barrio_id" class="form-control" >
                <option value="0" selected>--Seleccione un barrio--</option>
                    @foreach ($barrios as $barrio)
                        @if ($barrio->id == $socio->domicilio->barrio_id)
                            <option selected value="{{$barrio->id}}">{{$barrio->nombre}}</option>
                        @else
                            <option value="{{$barrio->id}}">{{$barrio->nombre}}</option>
                        @endif
                    @endforeach
            </select>
            <label>Calle</label>
            <input type="text" value="{{$socio->domicilio->calle}}" name="calle" class="form-control" placeholder="Ingrese el nombre de la calle">
            <label>Altura</label>
            <input type="text" value="{{$socio->domicilio->altura}}" name="altura" class="form-control" placeholder="Ingrese la altura">
            
            <br>
            {{-- <div class="form-inline">
                <label>Calle</label>
                <input type="text" name="calle" class="form-control">
                <label>Altura</label>
                <input type="text" name="altura" class="form-control">
            </div> --}}
            
        </div>
      
        <div class="text-right">
            <input type="submit" value="Modificar" class="btn btn-success">
        </div>
       

    </form>
@endsection