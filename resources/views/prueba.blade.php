@extends('admin_panel.index')

@section('content')
        <button class="mensaje">Pulsar</button>
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
