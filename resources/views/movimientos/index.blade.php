@extends('admin_panel.index')

@section('content')
    <h2>Movimientos Realizados</h2>
<br>
    <div class="form-group col-md-8">
            <a type="submit" href="{{ route('movimientos.createIngreso') }}" class="btn btn-xs btn-success"> Nuevo Ingreso <i class="fas fa-tags nav-icon"></i></a>
            <a type="submit" href="{{ route('movimientos.createTransferencia') }}" class="btn btn-xs btn-success"> Nueva Transferencia <i class="nav-icon fas fa-exchange-alt"></i></a>
    </div>
    <div class="form-group col-md-8">


    </div>
    <div class="card">
        <div class="card-header">
            <form class="form-group " method="GET" action="{{route('movimientos.pdf')}}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                            <label>Desde</label>
                            <input type="date" id="min" name="fecha1"  value=""  class="form-control" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Hasta</label>
                        <input type="date" id="max" name="fecha2"  value=""  class="form-control" >
                    </div>
                </div>
                <div class="col-5 ">
                        <a class="btn btn-primary btn-xs" id="filtrar"><i class="fas fa-filter nav-icon"></i></a>
                </div>

                <div class="col-md-1">
                        <button type="submit" class="btn btn-xs btn-danger " >Generar <i class="fa fa-file-pdf"></i></button>

                </div>
            </div>
            @csrf

        </form>
        </div>
            <div class="card-body">
                <div class="table-responsive table-sm">
                    <table id="movimientos" class="table table-bordered table-striped table-hover datatable">
                    <thead>
                      <tr>
                        <th>Nº</th>
                        <th>Tipo de Movimiento</th>
                        <th>Fecha de Movimiento</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Almacen Origen</th>
                        <th>Almacen Destino</th>
                        <th>Accion</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientos as $movimiento)

                            <tr>
                                <td>{{$movimiento->id}}</td>
                                <td>{{$movimiento->tipoMovimiento->nombre}}</td>
                                <td>{{$movimiento->cabeceraMovimiento->getFechaMovimiento()}}</td>
                                <td>{{$movimiento->producto->nombre}}</td>
                                <td>{{$movimiento->cantidad}}</td>
                                <td>
                                    @if ($movimiento->almacenOrigen == null)
                                    <span class="badge badge-warning">N/A</span>
                                    @else
                                    <span class="badge badge-info">{{$movimiento->almacenOrigen->denominacion}}</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-info">{{$movimiento->almacenDestino->denominacion}}</span></td>
                                <td width ="150px" class="text-center">
                                    <a href="{{route('movimientos.show' , $movimiento)}}" class="btn btn-xs btn-primary">Ver mas</a>
                                    @can('movimientos_edit')
                                        <a href=""  class="btn btn-secondary btn-xs " data-toggle="modal" data-target="#editar{{$movimiento->id}}" >Editar</a>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editar{{$movimiento->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edicion de Movimiento</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form class="form-group " method="POST" action="/movimientos/{{$movimiento->id}}">
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="text-left">
                                                        <h5 class="">Movimiento Nº {{$movimiento->id}} </h5>
                                                        <p>Tipo de Movimiento: {{$movimiento->tipoMovimiento->nombre}}</p>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary btn-sm ">Guardar</button>
                                                </div>
                                                @csrf
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                    @endcan
                                    <form method="POST" action="movimientos/{{$movimiento->id}}" onsubmit="return confirm('Desea borrar a {{$movimiento->id}}')" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        @can('movimientos_destroy')
                                            <input value="Borrar" type="submit" class="btn btn-sm btn-danger btn-xs btn-delete">
                                        @endcan
                                    </form>


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
        $(function () {
          $('#movimientos').DataTable({
            "order": [[ 0, "desc" ]]
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
    var table = $('#movimientos').DataTable();


    // Event listener to the two range filtering inputs to redraw on input
    // $('#min, #max').keyup( function() {
    //     table.draw();
    // } );
    $('#filtrar').click(function(){

        var fec1 =  $('#min').val() ;
        var fec2 =  $('#max').val() ;
        if((fec1 != "") && (fec2 != "")){

            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var f1 =  $('#min').val() ;
                    var min = moment(f1)

                    var f2 =  $('#max').val() ;
                    var max = moment(f2) ;

                    //console.log(moment(min).isSameOrBefore(max)) ;
                    // console.log(moment(f1).isSameOrBefore(f2)) ;

                    //var min =  new Date("25/08/2019" , "DD/MM/YYYY") ;
                    //var min = moment(new Date()).format("DD/MM/YYYY")
                    //var otro = moment(new Date("25/10/2019")).format("DD/MM/YYYY")
                    // console.log(moment(otro, "DD/MM/YYYY").isSameOrAfter(min, "DD/MM/YYYY"));


                    //var max =  new Date("2019-09-25") ;
                    // console.log(max) ;

                    // var s = new Date(data[2]) // use data for the age column
                    var d = data[2]
                    var datearray = d.split("/");
                    var newdate =   datearray[2] + '/'+ datearray[1] + '/' + datearray[0] ;
                    var s = new Date(newdate)
                    var startDate = moment(s)
                    console.log(startDate)

                    //console.log(newdate) ;

                    // console.log(startDate)
                    // console.log(moment(startDate).isSameOrAfter(min))

                    // console.log(s1) ;
                    if  ( ( min == "" || max == "" ) || ( moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) ) )
                    {
                        return true;
                    }
                    return false;

                    // if(min == null && max == null){
                    //     return false ;
                    // }
                    // if(min == null && startDate <= max){
                    //     return true ;
                    // }
                    // if(max == null && startDate >= min){
                    //     return true ;
                    // }
                    // if(startDate<= max && startDate >= min){
                    //     return true ;
                    // }

                    // return false ;
                    // if ( ( isNaN( min ) && isNaN( max ) ) ||
                    //      ( isNaN( min ) && age <= max ) ||
                    //      ( min <= s   && isNaN( max ) ) ||
                    //      ( min <= age   && age <= max ) )
                    // {
                    //     return true;
                    // }
                    // return false;
                }
            );
            table.draw();

        }else{
            console.log(fec1)
            swal({
            title: "Alerta",
            text: "Seleccione un rango de fechas!",

            });
        }

    }) ;
} );


</script>

@endpush
