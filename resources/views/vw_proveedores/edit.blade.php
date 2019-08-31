@extends('layouts.app')

@section('content')

<form class="form-group " method="POST" action="/proveedores/{{$proveedor->id}}" >
    @method('PATCH')
    @include('vw_proveedores.form')
    <div class="text-right">
            <input type="reset" value="Limpiar" class="btn btn-secondary">
            <button type="submit" class="btn btn-success">Modificar</button>
    </div>
</form>

@endsection

