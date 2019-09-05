@extends('admin_panel.index')

@section('content')

	<h1>Edicion de Usuarios</h1>
    <form class="form-group " method="POST" action="/permisos/{{$permiso->id}}" >
        @method('PUT')
        @include('permisos.form')
        <div class="text-right">
                <input type="reset" value="Limpiar" class="btn btn-secondary">
                <button type="submit" class="btn btn-success">Modificar</button>
        </div>
    </form>

@endsection

