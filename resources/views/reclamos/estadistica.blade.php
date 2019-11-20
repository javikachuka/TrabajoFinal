@extends('admin_panel.index')

@section('content')

<div class="card">
    <form class="form-group " method="GET" action="{{route('zonasConMasReclamos.pdf')}}">

        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <label for="">Año</label>
                    <select name="anio" id="anio" class=" js-example-basic-single form-control" required>
                        <option value="" selected disabled>--Seleccione un año--</option>
                        @foreach ($anios as $a)
                        <option value="{{$a}}" @if($anio !=null) @if($anio==$a) selected @endif @endif>{{$a}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="filtro" class="btn btn-sm btn-primary">Filtrar</button>
                </div>
                <div class="offset-5 col-md-1">
                    <button type="submit" class="btn btn-xs btn-danger ">Generar <i
                            class="fa fa-file-pdf"></i></button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div width="50%">
                {!! $estadisReclamos->container() !!}
            </div>
        </div>
        @csrf
    </form>
</div>


{!! $estadisReclamos->script() !!}
@endsection
@push('scripts')
<script>
    $('#filtro').on('click', function(){
        var anio = $('#anio').val() ;
        var url = "{!! route('estadistica.filtroZonas', ":id") !!}" ;
        url = url.replace(':id' , anio) ;
        document.location.href= url;
        // $('#formulario').attr('action', url);
        // $("#formulario").submit();
    }) ;

</script>
@endpush
