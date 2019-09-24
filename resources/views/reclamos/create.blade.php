@extends('admin_panel.index')

@section('content')

    <h2>Carga de Nuevo Reclamo</h2>

    <div class="card">
    <div class="card-body">
      <form class="form-group " method="POST" action="/reclamos" >
        <div class="row">
            <div class="col-sm-3">
                <label for="">Socio</label>
                <select class="seleccion form-control" name="socio_id">
                    <option value="" disabled selected>--Seleccione un socio--</option>
                    @foreach($socios as $socio)
                        <option value="{{$socio->id}}">{{$socio->apellido . ' ' . $socio->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                    <label for="">Tipo de Reclamo</label>
                    <select class="seleccion form-control" name="tipoReclamo_id" id="tipoReclamo">
                        <option value="" disabled selected>--Seleccione un tipo--</option>
                        @foreach($tipos_reclamos as $tipo_reclamo)
                            <option value="{{$tipo_reclamo->id}}">{{$tipo_reclamo->nombre}}</option>
                        @endforeach
                    </select>
            </div>
            {{-- <div class="col-md-3">
                <label for="">Requisitos</label>
                <select class="seleccion form-control" name="requisitos" id="requisitos" >
                    <option value="" disabled selected>--Seleccione--</option>
                </select>
            </div> --}}


            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Fecha del Reclamo</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fal fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="date" name="fecha" class="form-control" required value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" id="">
                    </div>
                </div>
            </div>

        </div>
        <div class="form-group">
                <label for="">Requisitos Necesarios</label>
                <ul id="lista" style="list-style:none">
                    <li><i class="text-muted">Seleccione un tipo de reclamo para ver sus requisitos.</i></li>
                </ul>
         </div>

        <div class="form-group">
        <label for="">Detalles</label>
        <textarea name="detalle" class="form-control" id="" cols="10" rows="3"></textarea>
        </div>

        <div class="text-left">
                <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm">
                <button type="submit" class="btn btn-success btn-sm">Generar Reclamo</button>
        </div>
        @csrf
      </form>
    </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.seleccion').select2();
    });
</script>

<script>
    $(document).ready(function(){
        // $('#tipoReclamo').change(function(){
        //     var tip_rec_id = $(this).val();
        //     // alert(tip_rec_id) ;
        //     //AJAX
        //     $.get('/api/reclamos/create/requisitos/'+tip_rec_id+'', function(data){
        //         var html_select = '<option value="" selected disabled>--Seleccione--</option>' ;
        //         for(var i = 0 ; i<data.length ; i++){
        //             // console.log(data[i]) ;
        //              html_select += '<option value="'+data[i].id+'">'+data[i].nombre+'</option>' ;
        //         }
        //          $('#requisitos').html(html_select);
        //     });
        // });

        $('#tipoReclamo').change(function(){
            var tip_rec_id = $(this).val();
            // alert(tip_rec_id) ;
            //AJAX

            $.get('/api/reclamos/create/requisitos/'+tip_rec_id+'', function(data){
                var html_select = '<li> </li>';
                $('#lista').html(html_select) ;
                if(data.length>0){
                    for(var i = 0 ; i<data.length ; i++){
                        // console.log(data[i]) ;
                        html_select += '<li> <div class="custom-control custom-checkbox"> <input type="checkbox" value="'+data[i].id+'" class="custom-control-input" name="requisitos[]" id="customCheck'+data[i].id+'"> <label class="custom-control-label" for="customCheck'+data[i].id+'">'+data[i].nombre+'</label> </div> </li>' ;
                    }
                    $('#lista').html(html_select);
                } else {
                    html_select = '<li> <i class="text-muted">No presenta requisitos asociados.</i> </li>' ;
                    $('#lista').html(html_select);
                }
            });
        });



    });

</script>

@endpush
