@extends('admin_panel.index')

@section('content')

	<h1>Edicion de Empleados</h1>
    <form class="form-group " method="POST" action="{{route('users.update' , $user->id)}}" enctype="multipart/form-data">
        @method('PUT')
        @include('usuarios.form')
        <div class="text-right">
                <input type="reset" value="Limpiar" class="btn btn-secondary">
                <button type="submit" class="btn btn-success">Modificar</button>
        </div>
    </form>

@endsection
@push('scripts')
<script>
        $(document).ready(function(){
            $('#dni').mask('00.000.000');
        });
</script>
@endpush
