@extends('admin_panel.index')

@section('content')



<div class="card">
    <div class="card-header">
        <h3>Nuevo Reclamo</h3>
    </div>
    <div class="card-body">
        <form class="form-group " method="POST" action="/reclamos">
            <div class="row">
                <div class="col-sm-3">
                    <label for="">Socio</label>
                    <select class="seleccion form-control" name="socio_id" id="socio" required>
                        <option value="" disabled selected>--Seleccione un socio--</option>
                        @foreach($socios as $socio)
                        <option value="{{$socio->id}}">{{$socio->apellido . ' ' . $socio->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-1 d-flex align-items-end py-2">
                    <div class="form-group">
                        <a href="" class="btn btn-primary btn-xs " data-toggle="modal" data-target="#buscar"><i
                                class="fa fa-search"></i></a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label for="">Tipo de Reclamo</label>
                    <select class="seleccion form-control" name="tipoReclamo_id" id="tipoReclamo" required>
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
                <div class="col-md-1">

                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Fecha del Reclamo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fal fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="date" name="fecha" class="form-control" required
                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                max="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" id="">
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


<!-- Modal Buscar -->
<div class="modal fade" id="buscar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscar Socio</h5>
                <button type="button" id="cerrarModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                </div>
                <div class="table-responsive">
                    <table id="socios" class="table table-sm table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th scope="col">Apellido y Nombre</th>
                                <th scope="col">DNI</th>
                                <th scope="col">Nº de Conexion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($socios as $socio)
                            <tr>
                                <td>{{$socio->apellido}} {{$socio->nombre}}</td>
                                <td>{{$socio->dni}}</td>
                                <td>{{$socio->nro_conexion}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" id="cerrar" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="button" id="seleccionar" class="btn btn-primary btn-sm ">Seleccionar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.seleccion').select2({
            sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
        });
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
            var url = "{{ route('tipoReclamos.cargarRequisitos', ":id") }}" ;
            url = url.replace(':id' , tip_rec_id) ;
            // alert(tip_rec_id) ;
            //AJAX

            $.get(url, function(data){
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

{{-- <script>


$(document).ready(function() {
    var table = $('#socios').DataTable();

    // Event listener to the two range filtering inputs to redraw on input
    $('#busc').keyup( function() {
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var dni = parseInt( $('#busc').val(), 10 );
                var dniTabla = parseInt( data[1] ) || 0; // use data for the age column

                if ( dni <= dniTabla )
                {
                    return true;
                }
                return false;
            }
        );
        table.draw();
    } );
} );
</script> --}}

<script>
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#socios thead tr').clone(true).appendTo( '#socios thead' );
    $('#socios thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    var table = $('#socios').DataTable( {
        select: true,
        orderCellsTop: true,
        fixedHeader: true,
        paginate: false,
        "searching": true,
            "info": false,
            "autoWidth": false,
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
    } );

    $('#seleccionar').click( function () {
        var valor = table.row('.selected').index();
        console.log(valor);
        $("#socio ").prop("selectedIndex", valor+1).change();
        $('#buscar').modal('hide');
        // $(".modal-fade").modal("hide");
        $(".modal-backdrop").remove();
    } );

} );
</script>


{{-- <script>
$(document).ready(function() {
    var table = $('#socios').DataTable();

    $('#socios tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
} );
</script> --}}


@endpush
