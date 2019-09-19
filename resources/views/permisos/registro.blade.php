@extends('admin_panel.index')

@section('content')
    <h1>Registro de Permisos</h1>
    <form class="form-group " method="POST" action="/permisos" >
        @include('permisos.form')
        <div class="text-right">
                <input type="reset" value="Limpiar" class="btn btn-secondary">
                <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </form>
@endsection



