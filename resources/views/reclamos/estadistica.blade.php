@extends('admin_panel.index')

@section('content')

<div width="50%">
    {!! $estadisReclamos->container() !!}
</div>
<div class="content">
    <div class="row d-flex justify-content-end">
        <div class="col-md-1 ">
            <a href="{{route('zonasConMasReclamos.pdf')}}" class="btn btn-xs btn-danger ">Generar <i class="fa fa-file-pdf"></i></a>
        </div>
    </div>
</div>

<br>


{!! $estadisReclamos->script() !!}
@endsection
@push('scripts')

@endpush
