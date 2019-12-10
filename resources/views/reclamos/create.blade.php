@extends('admin_panel.index')

@section('content')



<div class="card">
    <div class="card-header">
        <h3>Nuevo Reclamo</h3>
    </div>
    <div class="card-body">
        <form class="form-group " method="POST" action="/reclamos">
            <div class="row">
                <div class="col-sm-4">
                    <label for="">Socio</label>
                    <select class="seleccion form-control" name="socio_id" id="socio" required>
                        <option value="" disabled selected>--Seleccione un socio--</option>
                        @foreach($socios as $socio)
                        <option value="{{$socio->id}}" @if(old('socio_id')==$socio->id) selected
                            @endif>{{$socio->apellido . ' ' . $socio->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-1 d-flex align-items-end py-2">
                    <div class="form-group">
                        <a href="" class="btn btn-primary btn-xs " data-toggle="modal" data-target="#buscar"><i
                                class="fa fa-search"></i></a>
                    </div>
                    @can('socios_create')
                    <div class="form-group ml-1">
                        <a href="{{route('socios.createReclamos')}}" class="btn btn-primary btn-xs "><i
                                class="fa fa-plus"></i></a>
                    </div>
                    @endcan
                </div>
                <div class="col-sm-4 offset-1">
                    <label for="">DNI</label>
                    <div class="form-group">
                        <input type="text" id="dni" class="form-control" disabled value="">
                    </div>
                </div>
                <div class="col-sm-1">

                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="">Nº de Conexion</label>
                    <select class="form-control" name="nro_conexion" id="nro_conexion" required>
                        <option value="" selected disabled>--Seleccione--</option>
                    </select>
                </div>
                @can('socios_create')
                <div class="col-sm-1 d-flex align-items-end py-2">
                    <div class="form-group ml-1">
                        <button type="button" class="btn btn-primary btn-xs " disabled id="crearConex"
                            data-toggle="modal" data-target="#crearConexion"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                @endcan
                <div class="col-sm-4 offset-1">
                    <label for="">Direccion</label>
                    <div class="form-group">
                        <input type="text" id="direc" class="form-control" disabled value="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
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


                <div class="col-md-4 offset-2">
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
                                min="{{ Carbon\Carbon::now()->subDay()->format('Y-m-d') }}"
                                max="{{ Carbon\Carbon::now()->format('Y-m-d') }}" id="">
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

            <div class="text-right">
                <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>
                {{-- <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm"> --}}
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($socios as $socio)
                            <tr>
                                <td>{{$socio->apellido}} {{$socio->nombre}}</td>
                                <td style="text-align: right">{{$socio->dni}}</td>
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

<!-- Modal Create -->
<div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Socio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-group " method="POST" action="{{route('socios.store')}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" required value="{{ old('apellido')}}" class="form-control">
                        <div class="text-danger">{{$errors->first('apellido')}} </div>
                    </div>
                    <div class="form-group">
                        <label>Nombre/s</label>
                        <input type="text" name="nombre" required value="{{  old('nombre')}}" class="form-control">
                        <div class="text-danger">{{$errors->first('nombre')}} </div>
                    </div>
                    <div class="form-group">
                        <label>DNI</label>
                        <input type="text" name="dni" required value="{{  old('dni')}}" class="form-control"
                            data-mask="00.000.000">
                        <div class="text-danger">{{$errors->first('dni')}} </div>
                    </div>
                    <div class="form-group">
                        <label>Nº de Conexion</label>
                        <input type="text" name="nro_conexion" required value="{{old('nro_conexion')}}"
                            class="form-control">
                        <div class="text-danger">{{$errors->first('nro_conexion')}} </div>
                    </div>
                    <label for="">Direccion</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Calle</label>
                                    <div class="input-group">
                                        <input name="calle" type="text" value="{{  old('calle') }}" required
                                            class="form-control" placeholder="Calle">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">-</span>
                                        </div>
                                        <input name="altura" type="text" value="{{ old('altura')}}" required
                                            class="form-control col-md-3" placeholder="Altura">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <select name="zona_id" class="form-control" required>
                            <option value="" selected disabled>--Seleccione--</option>
                            @foreach ($zonas as $zona)
                            <option value="{{$zona->id}}" }>{{$zona->nombre}}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">{{$errors->first('zona_id')}} </div>
                    </div>
                </div>
                <input type="hidden" name="modal" id="modalAbierto" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-sm ">Guardar</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
<!-- Modal Crear Conexion -->
<div class="modal fade" id="crearConexion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Conexion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-group " method="POST" action="{{route('socios.nuevaConexion')}}">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Socio</label>
                        <input type="text" name="socio" id="nombreSocio" required disabled
                            value="{{session('nombreSoc')}}" class="form-control">
                        <div class="text-danger">{{$errors->first('socio')}}</div>
                        <input type="hidden" name="socio_id" id="idSocio" value="{{old('socio_id')}}">
                        <input type="hidden" name="socioNombre" id="socioNombre" value="">
                    </div>
                    <div class="form-group">
                        <label>Nº de Conexion</label>
                        <input type="number" name="nro_conexion" required value="{{old('nro_conexion')}}"
                            class="form-control">
                        <div class="text-danger">{{$errors->first('nro_conexion')}}</div>
                    </div>
                    <label for="">Direccion</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Calle</label>
                                    <div class="input-group">
                                        <input name="calle" type="text" value="{{old('calle')}}" required
                                            class="form-control" placeholder="Calle">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">-</span>
                                        </div>
                                        <input name="altura" type="text" value="{{old('altura')}}" required
                                            class="form-control col-md-3" placeholder="Altura">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Zona</label>
                        <select name="zona_id" class="form-control" required>
                            <option value="" selected disabled>--Seleccione--</option>
                            @foreach ($zonas as $zona)
                            <option value="{{$zona->id}}" @if($zona->id == old('zona_id')) selected
                                @endif>{{$zona->nombre}}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">{{$errors->first('zona_id')}} </div>
                    </div>
                </div>
                <input type="hidden" name="modal" id="modalAbierto" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-sm ">Guardar</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- <script>
    $(document).ready(function() {

    });
</script> --}}
<script>
    @if($errors->any() )
                $(function(){
                    $('#crearConexion').modal('show');
                });
            @endif
</script>

<script>
    @if(session('confirmar'))
            Confirmar.fire() ;
        @elseif(session('cancelar'))
            Cancelar.fire();
        @elseif(session('borrado'))
            Borrado.fire();
        @endif
</script>

<script>
    $(document).ready(function(){
        $('#socio').change(function(){
            console.log('holamda');
            $('#crearConex').attr('disabled', false);
            $('#direc').val('');
            var id = $(this).val();
            var socio = $('#socio option:selected').text() ;
            $('#nombreSocio').val(socio) ;
            $('#socioNombre').val(socio) ;
            $('#idSocio').val(id) ;
            var url = "{{ route('socios.obtenerConexiones', ":id") }}" ;
            url = url.replace(':id' , id) ;

            var id2 = $(this).val();
            var url2 = "{{ route('socios.obtenerDni', ":id") }}" ;
            url2 = url2.replace(':id' , id2) ;
            // alert(tip_rec_id) ;
            //AJAX
            $.get(url, function(data){
                var html_select = '<option value="" selected disabled>--Seleccione--</option>' ;
                var html_select ;
                for(var i = 0 ; i<data.length ; i++){
                    // console.log(data[i]) ;
                     html_select += '<option value="'+data[i]+'">'+data[i]+'</option>' ;
                }
                 $('#nro_conexion').html(html_select);
            });

            $.get(url2, function(data){
                $('#dni').val(data);
            });
        });

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


        $('.seleccion').select2({
            sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
        });

        $('#nro_conexion').change(function(){
            var num_conex = $(this).val();
            var socio_id = $('#socio').val();
            var url = "{{ route('socios.obtenerDireccion', [":id" , ":num1"]) }}" ;
            url = url.replace(':id' , socio_id) ;
            url = url.replace(':num1' , num_conex) ;
            // alert(tip_rec_id) ;
            //AJAX

            $.get(url, function(data){
                console.log(data);
                $('#direc').val(data);
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
        $(this).html( '<input type="text" class="form-control" placeholder="Buscar por '+title+'" />' );

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
