@extends('admin_panel.index')

@section('content')
    <h1>Registro de Usuarios</h1>
    <form class="form-group " method="POST" action="/users" >
        @include('usuarios.form')
        <div class="text-right">
                <input type="reset" value="Limpiar" class="btn btn-secondary">
                <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </form>
@endsection


