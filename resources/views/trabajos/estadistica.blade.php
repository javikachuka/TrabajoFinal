@extends('admin_panel.index')

@section('content')

<div width="50%">
    {!! $prueba->container() !!}
</div>
<br>

<div width="50%">
    {!! $trabajosMasFrecuentes->container() !!}
</div>



{!! $prueba->script() !!}
{!! $trabajosMasFrecuentes->script() !!}
@endsection
@push('scripts')

@endpush
