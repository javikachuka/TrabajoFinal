@extends('admin_panel.index')

@section('content')

<div class="card ">
    <div class="card-header">
        <div class="card-title">
            Filtros
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fal fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form class="form-group " method="GET" action="{{route('reclamos.pdf')}}">

            <div class="row d-flex justify-content-around">
                <div class="col-md-3">
                    <label for="">Tipo de Reclamo</label>
                    <select name="tipoReclamo_id" id="tipoReclamos" class="seleccion form-control">
                        <option value="" selected disabled>--Seleccione--</option>
                        @foreach ($tipoReclamos as $tipoRec)
                        <option value="{{$tipoRec->id}}">{{$tipoRec->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="">Socios</label>
                    <select name="socio_id" id="socios" class="seleccion form-control">
                        <option value="" selected disabled>--Seleccione--</option>
                        @foreach ($socios as $socio)
                        <option value="{{$socio->id}}">{{$socio->apellido}} {{$socio->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="">Estados</label>
                    <select name="estado_id" id="estados" class="form-control">
                        <option value="" selected disabled>--Seleccione--</option>
                        @foreach ($estados as $estado)
                        <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                        @endforeach
                    </select>
                </div>


            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Desde</label>
                        <input type="date" id="min" name="fecha1" value="" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Hasta</label>
                        <input type="date" id="max" name="fecha2" value="" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <button type="button" class="btn btn-secondary btn-xs mr-1" id="limpiar">Limpiar <i
                        class="fas fa-redo "></i></button>
                <button type="button" class="btn btn-primary btn-xs" id="filtrar">Filtrar <i
                        class="fas fa-filter "></i></button>

            </div>

    </div>
</div>

<div class="card animated fadeIn">
    <div class="card-header">
        <h3>Listado de Reclamos
            @can('reclamos_create')
            <button type="button" class="btn btn-primary btn-xs"
                onclick="location.href = '{{ route('reclamos.create') }}'">Nuevo Reclamo</button>
            @endcan
            <button type="submit" class="btn btn-xs btn-danger ">Generar <i class="fa fa-file-pdf"></i></button>
        </h3>
        @csrf
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="reclamos" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo de Reclamo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Socio</th>
                        <th>Detalles</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reclamos as $reclamo)

                    <tr>
                        <td>{{$reclamo->id}}</td>
                        <td>
                            <span>{{$reclamo->tipoReclamo->nombre}}</span>
                        </td>
                        <td>{{$reclamo->getFecha()}}</td>
                        <td>{{$reclamo->created_at->format('H:i:s')}}</td>
                        <td>{{$reclamo->direccion->socio->apellido}} {{$reclamo->direccion->socio->nombre}}</td>
                        <td>
                            @if($reclamo->detalle != null)
                            <span class="badge badge-light"> {{$reclamo->detalle}}</span>
                            @else
                            <span class="badge badge-light">Sin detalle</span>
                            @endif
                        </td>
                        <td>
                            @if($reclamo->tipoReclamo->trabajo != false)
                            @if($reclamo->trabajo->estado != null)
                            @if($reclamo->trabajo->estado->isUltimo($reclamo->tipoReclamo->flujoTrabajo->id))
                            <span class="badge badge-success">{{$reclamo->trabajo->estado->nombre}}</span>
                            @elseif($reclamo->trabajo->estado->nombre == 'FALTA' || $reclamo->trabajo->estado->nombre ==
                            'SIN EXISTENCIAS')
                            <span class="badge badge-danger">{{$reclamo->trabajo->estado->nombre}}</span>
                            @else
                            <span class="badge badge-info">{{$reclamo->trabajo->estado->nombre}}</span>
                            @endif
                            @else
                            <span class="badge badge-light">N/A</span>
                            @endif
                            @else
                            <span class="badge badge-success">{{$reclamo->historial->last()->estado->nombre}}</span>
                            @endif
                        </td>
                        <td width="200px">
                            @can('reclamos_show')
                            <a href="{{route('reclamos.show', $reclamo)}}" class="btn btn-xs btn-primary">Ver mas</a>
                            @endcan
                            @can('reclamos_edit')
                            <a href="{{ route('reclamos.edit', $reclamo) }}" class="btn btn-xs btn-secondary"> Editar
                            </a>
                            @endcan
                            @can('reclamos_destroy')
                            <form id="form-borrar{{$reclamo->id}}" method="POST"
                                action="{{route('reclamos.destroy' , $reclamo->id)}}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs btn-almacen"
                                    id="{{$reclamo->id}}">Borrar</button>
                            </form>
                            @endcan
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
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
    $(function () {
          $('#reclamos').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "order": [[ 0, "desc" ]] ,
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
          });
        });
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
    $(document).ready(function() {
        var table = $('#reclamos').DataTable();

        $('#limpiar').click(function(){
            // $("#tipoReclamos ").prop("selectedIndex", 0) ;
            $("#tipoReclamos").val(null).trigger("change");
            $("#socios").val(null).trigger("change");
            $("#estados ").prop("selectedIndex", 0) ;
            $('input[type=date]').val('');

            $.fn.dataTable.ext.search.pop(
                function( settings, data, dataIndex ) {
                    if(1){
                        return true ;
                    }
                    return false ;
                }
            );
            table.draw() ;
        }) ;

        $('#filtrar').click(function(){

            var fec1 =  $('#min').val() ;
            var fec2 =  $('#max').val() ;
            var filtro1 = $('#tipoReclamos').val() ;
            //no olvidarme de volver a poner (pop) las filas
            var filtro2 = $('#socios').val() ;
            var filtro3 = $('#estados').val() ;
            $.fn.dataTable.ext.search.pop(
                function( settings, data, dataIndex ) {
                    if(1){
                        return true ;
                    }
                    return false ;
                }
            );
            table.draw() ;

            if(filtro1 != null){
                var tipoRec = $('#tipoReclamos option:selected').text() ;
            }
            if(filtro2 != null){
                var socio = $('#socios option:selected').text() ;
            }
            if(filtro3 != null){
                var estado = $('#estados option:selected').text() ;
            }


            if((fec1 != "") && (fec2 != "")){

                var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){
                    var f1 =  $('#min').val() ;
                    var min = moment(f1) ;
                    var f2 =  $('#max').val() ;
                    var max = moment(f2) ;

                    var d = data[2]

                    var datearray = d.split("/");
                    var newdate =   datearray[2] + '/'+ datearray[1] + '/' + datearray[0] ;
                    var s = new Date(newdate)
                    var startDate = moment(s)

                    console.log(filtro3 == null)

                    if(filtro1 == null && filtro2 == null && filtro3 == null){
                        if  (
                                ( min == "" || max == "" ) ||
                                (
                                    (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) )
                                )
                            )
                        {
                            return true ;
                        }else{
                            return false;
                        }
                    }else if(filtro1 != null && filtro2 != null && filtro3 == null){
                        if  (
                                ( min == "" || max == "" ) ||
                                (
                                    (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) ) &&
                                    (tipoRec == data[1]) &&
                                    (socio == data[4])
                                )
                            )
                        {

                            return true ;
                        }else{
                            return false;
                        }
                    }else if(filtro1 != null && filtro2 == null && filtro3 == null){
                        if  (
                                ( min == "" || max == "" ) ||
                                (
                                    (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) ) &&
                                    (tipoRec == data[1])
                                )
                            )
                        {
                            return true ;
                        }else{
                            return false;
                        }
                    } else if(filtro1 == null && filtro2 != null && filtro3 == null ){
                        if  (
                                ( min == "" || max == "" ) ||
                                (
                                    (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) ) &&
                                    (socio == data[4])
                                )
                            )
                        {
                            return true ;
                        }else{
                            return false;
                        }

                    } else if(filtro1 == null && filtro2 == null && filtro3 != null ){
                        console.log(estado == data[6])
                        if  (
                                ( min == "" || max == "" ) ||
                                (
                                    (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) ) &&
                                    (estado == data[6])
                                )
                            )
                        {
                            return true ;
                        }else{
                            return false;
                        }
                    } else if(filtro1 == null && filtro2 != null && filtro3 != null ){
                        console.log(estado == data[6])
                        if  (
                                ( min == "" || max == "" ) ||
                                (
                                    (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) ) &&
                                    (socio == data[4]) &&
                                    (estado == data[6])
                                )
                            )
                        {
                            return true ;
                        }else{
                            return false;
                        }
                    } else if(filtro1 != null && filtro2 == null && filtro3 != null ){
                        console.log(estado == data[6])
                        if  (
                                ( min == "" || max == "" ) ||
                                (
                                    (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) ) &&
                                    (tipoRec == data[1]) &&
                                    (estado == data[6])
                                )
                            )
                        {
                            return true ;
                        }else{
                            return false;
                        }
                    } else if(filtro1 != null && filtro2 != null && filtro3 != null ){
                        console.log(estado == data[6])
                        if  (
                                ( min == "" || max == "" ) ||
                                (
                                    (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) ) &&
                                    (tipoRec == data[1]) &&
                                    (socio == data[4]) &&
                                    (estado == data[6])
                                )
                            )
                        {
                            return true ;
                        }else{
                            return false;
                        }
                    }
                }

                $.fn.dataTable.ext.search.push( filtradoTabla )


                table.draw()

            }else if(filtro1 != null && filtro2 == null && filtro3 == null){
                var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){

                    if  ( tipoRec == data[1]){
                        return true ;
                    }else{
                        return false;
                    }
                }

                $.fn.dataTable.ext.search.push( filtradoTabla )

                table.draw()

            }else if(filtro1 == null && filtro2 != null && filtro3 == null){
                var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){

                    if (socio == data[4]) {
                        return true ;
                    }else{
                        return false;
                    }
                }

                $.fn.dataTable.ext.search.push( filtradoTabla )

                table.draw()

            }else if(filtro1 != null && filtro2 != null && filtro3 == null){
                var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){

                    if(socio == data[4] && tipoRec == data[1]){
                        return true ;
                    } else{
                        return false ;
                    }
                }
                $.fn.dataTable.ext.search.push( filtradoTabla )

                table.draw()
            }else if(filtro1 == null && filtro2 == null && filtro3 != null){
                var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){

                    if(estado == data[6]){
                        return true ;
                    } else{
                        return false ;
                    }
                }
                $.fn.dataTable.ext.search.push( filtradoTabla )

                table.draw()
            }else if(filtro1 != null && filtro2 == null && filtro3 != null){
                var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){

                    if(estado == data[6] && tipoRec == data[1]){
                        return true ;
                    } else{
                        return false ;
                    }
                }
                $.fn.dataTable.ext.search.push( filtradoTabla )

                table.draw()
            }else if(filtro1 != null && filtro2 != null && filtro3 != null){
                var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){

                    if(estado == data[6] && tipoRec == data[1] && socio == data[4]){
                        return true ;
                    } else{
                        return false ;
                    }
                }
                $.fn.dataTable.ext.search.push( filtradoTabla )

                table.draw()
            }else if(filtro1 == null && filtro2 != null && filtro3 != null){
                var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){

                    if(estado == data[6] &&  socio == data[4]){
                        return true ;
                    } else{
                        return false ;
                    }
                }
                $.fn.dataTable.ext.search.push( filtradoTabla )

                table.draw()

            }else{

                swal({
                title: "Alerta",
                text: "Seleccione opciones de filtrado!",

                });
            }

        }) ;
    } );


</script>
<script>
    $('.btn-almacen').on('click', function(e){
                                var id = $(this).attr('id');
                            e.preventDefault();

                        swal({
                                title: "Cuidado!",
                                text: "Esta seguro que desea eliminar?",
                                icon: "warning",
                                dangerMode: true,

                                buttons: {
                                cancel: "Cancelar",
                                confirm: "Aceptar",
                                },
                            })
                            .then ((willDelete) => {
                                if (willDelete) {
                                $("#form-borrar"+id).submit();
                                }
                            });
                         });
</script>
@endpush
