@extends('admin_panel.index')

@section('content')

<div width="50%">
    {!! $prueba->container() !!}
</div>
<div class="content">
    <div class="row d-flex justify-content-end">
        <div class="col-md-1 ">
            <button onclick="location.href='{{route('trabajosConMayorDuracion.pdf')}}'" class="btn btn-xs btn-danger ">Generar <i class="fa fa-file-pdf"></i></button>
        </div>
    </div>
</div>
<br>

<div width="50%">
    {!! $trabajosMasFrecuentes->container() !!}
</div>
<div class="content">
    <div class="row d-flex justify-content-end">
        <div class="col-md-1 ">
            <button onclick="location.href='{{route('trabajosMasFrecuentes.pdf')}}'" class="btn btn-xs btn-danger ">Generar <i class="fa fa-file-pdf"></i></button>
        </div>
    </div>
</div>



{!! $prueba->script() !!}
{!! $trabajosMasFrecuentes->script() !!}
@endsection
@push('scripts')

@endpush
