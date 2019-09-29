@extends('admin_panel.index')

@section('content')
    <h1>Registro de Empleados</h1>
    <form class="form-group " method="POST" action="{{route('users.store')}}" >
        @include('usuarios.form')
        <div class="text-right">
                <input type="reset" value="Limpiar" class="btn btn-secondary">
                <button type="submit" class="btn btn-success">Guardar</button>
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


