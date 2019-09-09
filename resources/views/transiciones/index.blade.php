@extends('admin_panel.index')

@section('content')
<h1>Transiciones</h1>
<form class="form-group " method="POST" action="/transiciones" >
@if (session()->has('message'))
    <div class="alert alert-danger">
        Error  {{session('message')}}
    </div>
@endif
<div class="form-group">
        <select name="flujoTrabajo" class="form-control" required>
            <option value="0" selected>--Seleccione un flujo--</option>
                @foreach ($flujosTrabajo as $flujoTrabajo)
                    <option value="{{$flujoTrabajo->id}}">{{$flujoTrabajo->nombre}}</option>
                @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" required value=""  class="form-control">
    </div>
    <label>Estado Inicial</label>
    <div class="form-group">
        <select name="estadoInicial" class="form-control" required>
            <option value="0" selected>--Seleccione un flujo--</option>
                @foreach ($estados as $estado)
                    <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                @endforeach
        </select>
    </div>
    <label>Estado Final</label>
    <div class="form-group">
        <select name="estadoFinal" class="form-control" required>
            <option value="0" selected>--Seleccione un flujo--</option>
                @foreach ($estados as $estado)
                    <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                @endforeach
        </select>
    </div>

        <div class="text-right">
                <input type="reset" value="Limpiar" class="btn btn-secondary">
                <button type="submit" class="btn btn-success">Guardar</button>
        </div>
        @csrf
    </form>
@endsection

