@extends('admin_panel.index')

@section('content')

	<h1>Edicion de Empleados</h1>
    <form class="form-group " method="POST" action="/users/{{$user->id}}" >
        @method('PUT')
        @include('usuarios.form')
        <div class="text-right">
                <input type="reset" value="Limpiar" class="btn btn-secondary">
                <button type="submit" class="btn btn-success">Modificar</button>
        </div>
    </form>

@endsection
<script>
        $(document).ready(function(){
            $('#dni').mask('00.000.000');
        });
</script>
