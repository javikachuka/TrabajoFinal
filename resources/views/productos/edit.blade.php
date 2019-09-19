@extends('admin_panel.index')

@section('content')

<form class="form-group " method="POST" action="/productos/{{$producto->id}}" >
    @method('PUT')
    <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card card-success">
                        <div class="card-header">
                                <h2 class="card-title">Datos del Producto</h2>
                        </div>
                        <div class="card-body">
                            @include('productos.form')
                        </div>
                        <div class="card-footer">
                            <p><i class="text-danger">(*)</i>Los campos son requeridos</p>
                            <div class="text-right">
                                    <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm">
                                    <button type="submit" class="btn btn-success btn-sm">Modificar</button>
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
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endpush
