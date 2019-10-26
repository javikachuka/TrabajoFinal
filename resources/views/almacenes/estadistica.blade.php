@extends('admin_panel.index')

@section('content')

<div width="50%">
    {!! $estadisAlmacen->container() !!}
</div>
<div class="content">
    <div class="row d-flex justify-content-end">
        <div class="col-md-1 ">
            <button type="submit" class="btn btn-xs btn-danger ">Generar <i class="fa fa-file-pdf"></i></button>
        </div>
    </div>
</div>

<br>


{!! $estadisAlmacen->script() !!}
@endsection
@push('scripts')

@endpush
