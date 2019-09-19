@extends('admin_panel.index')

@section('content')

<form class="form-group " method="POST" action="/roles" >
    @include('roles.form')
    <div class="text-right">
            <input type="reset" value="Limpiar" class="btn btn-secondary">
            <button type="submit" class="btn btn-success">Guardar</button>
    </div>
</form>

@endsection
