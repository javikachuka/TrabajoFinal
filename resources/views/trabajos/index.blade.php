@extends('admin_panel.index')

@section('content')



<div class="card">
    <div class="card-header">
        <h3>Listado de Trabajos</h3>
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        Filtros <i class="fal fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content">
                    <div class="col-md-3">

                            <label for="">Estados</label>
                            <select name="producto_id" id="estados" class="form-control" >
                                <option value="">--Seleccione--</option>
                                @foreach ($estados as $estado)
                                    <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-end">
                    <button class="btn btn-secondary btn-xs mr-1" id="limpiar">Limpiar <i class="fas fa-redo "></i></button>
                    <button type="button" class="btn btn-primary btn-xs" id="filtrar">Filtrar  <i class="fas fa-filter "></i></button>

                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="trabajos" class="table table-bordered table-striped table-hover datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tipo de Trabajo</th>
                    <th>Fecha</th>
                    <th>Ubicacion</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Empleado/s</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($trabajos as $trabajo)

                        <tr>
                            <td>{{$trabajo->id}}</td>
                            <td>
                                <span>{{$trabajo->reclamo->tipoReclamo->nombre}} </span>
                            </td>
                            <td>{{$trabajo->getFecha()}}</td>
                            <td><p>{{$trabajo->reclamo->socio->direccion->calle}} {{$trabajo->reclamo->socio->direccion->altura}} , {{$trabajo->reclamo->socio->direccion->zona->nombre}}</p> </td>
                            <td><span class="badge badge-warning">{{$trabajo->reclamo->tipoReclamo->prioridad->nombre}}</span></td>
                            <td>
                                @if($trabajo->estado != null)
                                    <span class="badge badge-info">{{$trabajo->estado->nombre}}</span>
                                @else
                                    <span class="badge badge-light">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if (!empty($trabajo->users))
                                    @foreach ($trabajo->users as $emple)
                                        <span class="badge badge-light">{{$emple->name}} {{$emple->apellido}}</span>
                                    @endforeach
                                @else
                                    <span class="badge badge-light">Sin Asignar</span>
                                @endif
                            </td>
                            <td width ="200px">
                                <a href="{{route('trabajos.show', $trabajo)}}" class="btn btn-xs btn-primary">Ver mas</a>
                                @if ($trabajo->reclamo->getCantidadEstados() <= 1)
                                    <a href="{{ route('trabajos.edit', $trabajo) }}" class="btn btn-xs btn-secondary"> Asignar a </a>
                                @else

                                @endif

                                @if ($trabajo->reclamo->getCantidadEstados() <= 1)
                                    <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#iniciarTrabajo{{$trabajo->id}}">Iniciar <i class="fad fa-play"></i></button>
                                @elseif($trabajo->reclamo->getCantidadEstados() == 2)
                                    <button class="btn btn-xs btn-danger" onclick="location.href='{{route('trabajos.finalizarTrabajo', $trabajo)}}'">Finalizar <i class="fad fa-window-close"></i></button>
                                @elseif($trabajo->reclamo->getCantidadEstados() >= 3)

                                @endif
                                {{-- <a class="btn btn-xs btn-success"  data-toggle="modal" data-target="#iniciarTrabajo"> Iniciar <i class="fad fa-play"></i> </a> --}}

                                {{-- <form method="POST" action="trabajos/{{$trabajo}}" onsubmit="return confirm('Desea borrar el trabajo {{$trabajo->nombre}}')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    @can('trabajos_destroy')
                                        <button type="submit" class="btn btn-sm btn-danger btn-xs btn-delete">Borrar</button>
                                    @endcan
                                </form> --}}
                            </td>
                          </tr>
                        <!-- Modal Inicio -->
                        <div class="modal fade" id="iniciarTrabajo{{$trabajo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Inicio de Trabajo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <form class="form-group " method="GET" action="{{route('trabajos.iniciarTrabajo', $trabajo)}}">

                                    <div class="modal-body">
                                        <strong><i class="fal fa-exclamation-circle mr-1"></i>Atencion</strong>
                                        <p>Debe encontrarse en la direccion "{{$trabajo->reclamo->socio->direccion->calle}}
                                            {{$trabajo->reclamo->socio->direccion->altura}},
                                            {{$trabajo->reclamo->socio->direccion->zona->nombre}}" para comenzar el trabajo!
                                        </p>

                                        <i class="text-muted">Si se encuentra en la direccion oprima CONTINUAR</i>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-sm ">Continuar</button>
                                    </div>
                                    @csrf
                                    </form>
                                </div>
                                </div>
                        </div>
                        {{-- <!-- Modal Fin -->
                        <div class="modal fade" id="finalizarTrabajo{{$trabajo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog " role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Finalizar Trabajo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <form class="form-group " method="GET" action="{{route('trabajos.finalizarTrabajo', $trabajo)}}">

                                    <div class="modal-body">
                                        <p><strong>Trabajo: </strong> {{$trabajo->reclamo->tipoReclamo->nombre}}</p> <br>
                                        <p><strong>Comenzado hace: </strong> {{$trabajo->diferencia()}}</p>
                                        <hr>
                                        <label for="" class="font-weight-light">Productos Utilizados</label>
                                        <div class="row d-flex justify-content-around">
                                                <div class=" col-sm-5">
                                                        <label for="">Producto</label>
                                                            <select name="producto" id="producto_id" class="js-example-basic-single form-control" required>
                                                                    @foreach ($productos as $producto)
                                                                        <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                                    @endforeach
                                                            </select>
                                                </div>
                                                <div class=" col-sm-2">
                                                        <label>Cantidad</label>
                                                        <input type="text" id="cantidad" name="cant"  value=""  class="form-control" placeholder="Mayor a 0">
                                                        <div>{{$errors->first('cantidad')}} </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <button type="button" class="addRow btn btn-primary btn-xs"><i class="fas fa-plus "></i></button>
                                                </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-sm ">Continuar</button>
                                    </div>
                                    @csrf
                                    </form>
                                </div>
                                </div>
                        </div> --}}
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
          $('#trabajos').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "order": [[ 5, "asc" ]] ,
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
$(document).ready(function(){
    var table = $('#trabajos').DataTable();


    $('#limpiar').click(function(){
        $("#estados ").prop("selectedIndex", 0) ;

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
        var filtro1 = $('#estados').val() ;
        if(filtro1 != null){
            var nombreEstado = $('#estados option:selected').text() ;
        }

        $.fn.dataTable.ext.search.pop(
            function( settings, data, dataIndex ) {
                if(1){
                    return true ;
                }
                return false ;
            }
        );
        table.draw() ;
        var filtradoTabla = function FuncionFiltrado(settings, data, dataIndex){

            if(nombreEstado == data[5]){
                return true ;
            }else{
                return false;
            }

        };
        $.fn.dataTable.ext.search.push( filtradoTabla );
        table.draw() ;

    }) ;

});

</script>

@endpush
