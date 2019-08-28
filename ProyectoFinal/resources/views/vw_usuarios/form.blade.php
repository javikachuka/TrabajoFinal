@extends('layouts.app')


@section('content')
@yield('estructura')
        <div class="container" >
                @yield('formulario')
                <h2>Datos Personales</h2>
                <label>Nombre</label>
                <input type="text" name="name" class="form-control">
                <label>Apellido</label>
                <input type="text" name="apellido" class="form-control">
                <label>DNI</label>
                <input type="text" name="dni" class="form-control">
                <br>
    
                <label for="">Fecha de Ingreso <input type="date" name="fecha_ingreso" id=""></label>
                <br>
                <label >Rol del Usuario</label>
                <select name="rol_id" class="form-control" >
                    <option value="0" selected>--Seleccione un rol--</option>
                        @foreach ($roles as $rol)
                            <option value="{{$rol->id}}">{{$rol->nombre}}</option>
                        @endforeach
                </select>
                <label>Telefono</label>
                <input type="text" name="telefono" class="form-control">
                <label>Email</label>
                <input type="text" name="email" class="form-control">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <h3>Domicilio</h3>
                <select name="barrio_id" class="form-control" >
                    <option value="0" selected>--Seleccione un barrio--</option>
                        @foreach ($barrios as $barrio)
                            <option value="{{$barrio->id}}">{{$barrio->nombre}}</option>
                        @endforeach
                </select>
                <label>Calle</label>
                <input type="text" name="calle" class="form-control">
                <label>Altura</label>
                <input type="text" name="altura" class="form-control">
                <br>
                @yield('botones')
            </div>
    
@endsection