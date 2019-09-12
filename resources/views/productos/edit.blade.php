@extends('admin_panel.index')

@section('content')

<form class="form-group " method="POST" action="/productos/{{$producto->id}}" >
    @method('PUT')
    @include('productos.form')
    <div class="text-right">
            <input type="reset" value="Limpiar" class="btn btn-secondary">
            <button type="submit" class="btn btn-success">Modificar</button>
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
