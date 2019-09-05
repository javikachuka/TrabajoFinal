@extends('admin_panel.index')

@section('content')

<form class="form-group " method="POST" action="/proveedores/{{$proveedor->id}}" >
    @method('PUT')
    @include('proveedores.form')
    <div class="text-right">
            <input type="reset" value="Limpiar" class="btn btn-secondary">
            <button type="submit" class="btn btn-success">Modificar</button>
    </div>
</form>

@endsection

