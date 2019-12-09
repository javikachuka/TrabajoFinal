@extends('admin_panel.index')

@section('content')

<form class="form-group " method="POST" action="/roles/{{$rol->id}}">
    @method('PUT')
    <div class="card">
        <div class="card-header">
            <h3>Edicion de Roles</h3>
        </div>
        <div class="card-body">
            @include('roles.form')
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>
                <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm">
                <button type="submit" class="btn btn-success btn-sm">Modificar</button>
            </div>
        </div>
    </div>

</form>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.permisos-js').select2();
    });

</script>
@endpush
