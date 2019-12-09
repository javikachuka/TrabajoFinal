@extends('admin_panel.index')

@section('content')

<div class="card">
    <form class="form-group " method="GET" action="{{route('zonasConMasReclamos.pdf')}}">

        <div class="card-header">
            <div class="row d-flex justify-content-center">
                <div class="col-md-4">
                    <label for="">Año</label>
                    <select name="anio" id="anio" class=" js-example-basic-single form-control" required>
                        <option value="" selected disabled>--Seleccione un año--</option>
                        @foreach ($anios as $a)
                        <option value="{{$a}}" @if($anio !=null) @if($anio==$a) selected @endif @endif>{{$a}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="">Tipo de Reclamo</label>
                    <select name="tipoReclamo" id="tipoReclamo" class=" tipRec-js form-control" required>
                        <option value="" selected disabled>--Seleccione--</option>
                        @foreach ($tipoReclamos as $t)
                        <option value="{{$t->id}}" @if($tip !=null) @if($tip==$t->id) selected @endif @endif>{{$t->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- <div class="offset-5 col-md-1">
                    <button type="submit" class="btn btn-xs btn-danger ">Generar <i
                            class="fa fa-file-pdf"></i></button>
                </div> --}}
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-1">
                    <button type="button" id="filtro" class="btn btn-xs btn-primary">Filtrar</button>
                </div>
                <div class="col-md-1 ">
                    <button type="button" onclick="location.href='{{route('estadistica.reclamos')}}'" id="filtro" class="btn btn-xs btn-secondary">Limpiar</button>
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
    $(document).ready(function() {
        $('.tipRec-js').select2();
        $('.tipRec-js').select2({
            sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
        });
    });

</script>
<script>
    $('#filtro').on('click', function(){
        var anio = $('#anio').val() ;
        var tipRec = $('#tipoReclamo').val() ;
        var url = "{!! route('estadistica.filtroZonas', [":anio", ":idRec"]) !!}" ;
        if(tipRec != null && anio != null){
            url = url.replace(':anio' , anio) ;
            url = url.replace(':idRec' , tipRec) ;
            document.location.href= url;

        }else if(tipRec != null && anio == null){
            url = url.replace(':anio' , 0) ;
            url = url.replace(':idRec' , tipRec) ;
            document.location.href= url;

        }else if(tipRec == null && anio != null){
            url = url.replace(':anio' , anio) ;
            url = url.replace(':idRec' , 0) ;
            document.location.href= url;
        }else{
            swal({
                title: "Alerta",
                text: "Seleccione opciones de filtrado!",

                });
        }
        // $('#formulario').attr('action', url);
        // $("#formulario").submit();
    }) ;

    // $('#limpiar').on('click', function(){
    //     $("#anio").val(null).trigger("change");
    //     $("#tipoReclamo").val(null).trigger("change");
    // });

</script>
@endpush
