@extends('admin_panel.index')

@section('content')

<div class="card">
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
        <form class="form-group " method="GET" action="{{route('asistencias.pdf', $empleado)}}">

            <div class="row ">
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
                <div class="col-md-1">

                </div>

                <div class="col-md-1 offset-4">
                    <button type="submit" class="btn btn-xs btn-danger ">Generar <i class="fa fa-file-pdf"></i></button>

                </div>
            </div>

            @csrf
        </form>
        <div class="row d-flex justify-content-center">
            <button class="btn btn-secondary btn-xs mr-1" id="limpiar">Limpiar <i class="fas fa-redo "></i></button>
            <button type="button" class="btn btn-primary btn-xs" id="filtrar">Filtrar <i
                    class="fas fa-filter "></i></button>

        </div>
    </div>

</div>

<div class="card">
    <div class="card-header">
        <h3>Listado de Asistencias </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <label for="">Empleado</label>
                <input type="text" disabled class="form-control" value="{{$empleado->apellido}} {{$empleado->name}}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <a href="javascript:history.back()" class="btn btn-primary btn-sm">Cambiar Seleccion</a>

            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table id="asistencias" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Dia</th>
                        <th>Fecha</th>
                        <th>Hora de Entrada</th>
                        <th>Hora de Salida</th>
                        <th>Horario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empleado->asistencias as $asistencia)

                    <tr>
                        <td>{{$asistencia->getNombreDia()}}</td>
                        <td>{{$asistencia->getDia()}}</td>
                        <td>{{$asistencia->horaEntrada}}</td>
                        <td>{{$asistencia->horaSalida}}</td>
                        <td>{{$asistencia->empleado->getHorario($asistencia)}}</td>
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
    $(function () {
          $('#asistencias').DataTable({

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
    $(document).ready(function() {
    var table = $('#asistencias').DataTable();


    $('#limpiar').click(function(){
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




    // Event listener to the two range filtering inputs to redraw on input
    // $('#min, #max').keyup( function() {
    //     table.draw();
    // } );
    $('#filtrar').click(function(){

        var fec1 =  $('#min').val() ;
        var fec2 =  $('#max').val() ;
        $.fn.dataTable.ext.search.pop(
            function( settings, data, dataIndex ) {
                if(1){
                    return true ;
                }
                return false ;
            }
        );
        table.draw() ;

        if((fec1 != "") && (fec2 != "")){

            var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){
                var f1 =  $('#min').val() ;
                var min = moment(f1) ;
                var f2 =  $('#max').val() ;
                var max = moment(f2) ;

                var d = data[1]
                var datearray = d.split("/");
                var newdate =   datearray[2] + '/'+ datearray[1] + '/' + datearray[0] ;
                var s = new Date(newdate)
                var startDate = moment(s)

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
            }

            $.fn.dataTable.ext.search.push( filtradoTabla )


            table.draw()

        }else{

            swal({
            title: "Alerta",
            text: "Seleccione un rango de fechas",
            });
        }

    }) ;
} );


</script>
@endpush
