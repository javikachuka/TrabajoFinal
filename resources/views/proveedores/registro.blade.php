@extends('admin_panel.index')

@section('content')

<form class="form-group " method="POST" action="{{route('proveedores.store')}}" >
    <div class="container-fluid">
            <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-success">
                    <div class="card-header">
                            <h2 class="card-title">Datos del Proveedor</h2>
                    </div>
                    <div class="card-body">
                        @include('proveedores.form')
                    </div>
                    <div class="card-footer">
                        <p><i class="text-danger">(*)</i>Los campos son requeridos</p>
                        <div class="text-right">
                                <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm">
                                <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
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
