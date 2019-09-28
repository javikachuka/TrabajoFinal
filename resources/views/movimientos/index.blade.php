@extends('admin_panel.index')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>Movimientos Realizados
                    <span></span>
                    <button class="btn btn-xs btn-primary" onclick="location.href='{{ route('movimientos.createIngreso')}}'">Nuevo Ingreso <i class="fas fa-tags nav-icon"></i></button>
                    <button class="btn btn-xs btn-primary" onclick="location.href='{{ route('movimientos.createTransferencia')}}'">Nueva Transferencia <i class="fas fa-exchange-alt "></i></button>
                    {{-- <a type="button" href="{{ route('movimientos.createIngreso') }}" class="btn btn-xs btn-success"> Nuevo Ingreso <i class="fas fa-tags nav-icon"></i></a> --}}
                    {{-- <a type="button" href="{{ route('movimientos.createTransferencia') }}" class="btn btn-xs btn-success"> Nueva Transferencia <i class="nav-icon fas fa-exchange-alt"></i></a> --}}
            </h3>
            <hr>

            <form class="form-group " method="GET" action="{{route('movimientos.pdf')}}">

            <div class="row">
                    <div class=" col-sm-2">
                            <label for="">Tipo de Movimiento</label>
                            <select name="tipoMovimiento_id" id="tipoMovimiento" class="form-control" >
                                <option value="" selected disabled>--Seleccione--</option>
                                @foreach ($tipoMovimientos as $tipoMov)
                                    <option value="{{$tipoMov->id}}">{{$tipoMov->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" col-sm-2">
                            <label for="">Producto</label>
                            <select name="producto_id" id="producto" class="form-control" >
                                <option value="" selected disabled>--Seleccione--</option>
                                @foreach ($productos as $producto)
                                    <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
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
                <div class="col-md-1">

                </div>

                <div class="col-md-1">
                        <button type="submit" class="btn btn-xs btn-danger " >Generar <i class="fa fa-file-pdf"></i></button>

                </div>
            </div>

            @csrf
        </form>
                    <div class="row ">
                        <div class="col-md-1 offset-4">
                            <button class="btn btn-secondary btn-xs" id="limpiar">Limpiar <i class="fas fa-redo "></i></button>
                        </div>
                        <button class="btn btn-primary btn-xs" id="filtrar">Filtrar <i class="fas fa-filter "></i></button>

                    </div>
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


    $('#limpiar').click(function(){
        $("#tipoMovimiento ").prop("selectedIndex", 0) ;
        $("#producto ").prop("selectedIndex", 0) ;
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
        var filtro1 = $('#tipoMovimiento').val() ;
        console.log(filtro1);
        //no olvidarme de volver a poner (pop) las filas
        var filtro2 = $('#producto').val() ;
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
            var tipMov = $('#tipoMovimiento option:selected').text() ;
        }
        if(filtro2 != null){
            var prod = $('#producto option:selected').text() ;
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

                if(filtro1 == null && filtro2 == null){
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
                }else if(filtro1 != null && filtro2 != null){
                    if  (
                            ( min == "" || max == "" ) ||
                            (
                                (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) ) &&
                                (tipMov == data[1]) &&
                                (prod == data[3])
                            )
                        )
                    {

                        return true ;
                    }else{
                        return false;
                    }
                }else if(filtro1 != null && filtro2 == null){
                    if  (
                            ( min == "" || max == "" ) ||
                            (
                                (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) ) &&
                                (tipMov == data[1])
                            )
                        )
                    {
                        return true ;
                    }else{
                        return false;
                    }
                } else if(filtro1 == null && filtro2 != null){
                    if  (
                            ( min == "" || max == "" ) ||
                            (
                                (moment(startDate).isSameOrAfter(min) && moment(startDate).isSameOrBefore(max) ) &&
                                (prod == data[3])
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

        }else if(filtro1 != null && filtro2 == null){
            var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){

                if  ( tipMov == data[1]){
                    return true ;
                }else{
                    return false;
                }
            }

            $.fn.dataTable.ext.search.push( filtradoTabla )

            table.draw()

        }else if(filtro1 == null && filtro2 != null){
            var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){

                if (prod == data[3]) {
                    return true ;
                }else{
                    return false;
                }
            }

            $.fn.dataTable.ext.search.push( filtradoTabla )

            table.draw()

        }else if(filtro1 != null && filtro2 != null){
            var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){

                if(prod == data[3] && tipMov == data[1]){
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

@endpush
