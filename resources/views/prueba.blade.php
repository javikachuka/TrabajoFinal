@extends('admin_panel.index')

@section('content')
<button class="mensaje">Pulsar</button>
<div width="50%">
    {!! $prueba->container() !!}
</div>

{!! $prueba->script() !!}
@endsection
@push('scripts')

<script>
    $('.mensaje').on('click',function(){
            mensaje();
        });
        function mensaje(){
            Alerta.fire(
                'Good job!',
                'You clicked the button!',
                'success'
                )
        }
</script>
@endpush
