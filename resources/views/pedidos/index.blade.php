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
        <form class="form-group " method="GET" action="#">

            <div class="row">
                {{-- <div class=" col-sm-2">
                    <label for="">Tipo de pedido</label>
                    <select name="tipopedido_id" id="tipopedido" class="form-control">
                        <option value="" selected disabled>--Seleccione--</option>
                        @foreach ($tipopedidos as $tipoMov)
                        <option value="{{$tipoMov->id}}">{{$tipoMov->nombre}}</option>
                @endforeach
                </select>
            </div>
            <div class=" col-sm-2">
                <label for="">Producto</label>
                <select name="producto_id" id="producto" class="form-control">
                    <option value="" selected disabled>--Seleccione--</option>
                    @foreach ($productos as $producto)
                    <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                    @endforeach
                </select>
            </div> --}}
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
        <h3>Pedidos Realizados
            <span></span>
            <button class="btn btn-xs btn-primary" onclick="location.href='{{ route('pedidos.create')}}'">Nuevo
                Pedido <i class="fas fa-tags nav-icon"></i></button>
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive ">
            <table id="pedidos" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Generado Por</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)

                    <tr>
                        <td style="text-align: end" width="5%">{{$pedido->id}}</td>
                        <td style="text-align: end">{{$pedido->getFecha()}}</td>
                        <td>
                            @if($pedido->proveedor != null)
                            {{$pedido->proveedor->nombre}}
                            @else
                            <div class="badge badge-light">Sin asignar</div>
                            @endif

                        </td>
                        <td>
                            @if($pedido->user != null)
                            <span class="badge badge-info">{{$pedido->user->apellido}} {{$pedido->user->name}}</span>
                            @else
                            <div class="badge badge-secondary">Sistema</div>
                            @endif
                        </td>
                        <td width="24%" style="text-align: center">
                            @if($pedido->proveedor != null)
                            <a href="{{route('pedidos.pdf', $pedido)}}" class="btn btn-xs btn-danger">Generar <i
                                    class="fal fa-file-pdf"></i></a>
                            @endif

                            <a href="{{route('pedidos.show' , $pedido)}}" class="btn btn-xs btn-primary">Ver
                                mas</a>
                            @if($pedido->proveedor == null)
                            <a href="{{route('pedidos.edit' , $pedido)}}" class="btn btn-xs btn-secondary">Finalizar
                                Pedido</a>
                            @endif
                            <form id="form-borrar{{$pedido->id}}" method="POST" action="{{route('pedidos.destroy' , $pedido)}}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                @can('pedidos_destroy')
                                <button type="submit" class="btn btn-danger btn-xs btn-almacen" id="{{$pedido->id}}">Borrar</button>
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
          $('#pedidos').DataTable({
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
