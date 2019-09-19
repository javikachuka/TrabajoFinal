@extends('admin_panel.index')

@section('content')

<form class="form-group " method="POST" action="/proveedores" >
    @include('proveedores.form')
    <div class="text-right">
            <input type="reset" value="Limpiar" class="btn btn-secondary">
            <button type="submit" class="btn btn-success">Guardar</button>
    </div>
</form>

@endsection
@push('scripts')

<script>
    $(document).ready(function(){
        $('#cuit').mask('00-00000000-0');
    });
</script>
<script>
        @if (session('alert'))
            Alerta.fire("{{ session('alert') }}");
        @endif
    </script>
@endpush
