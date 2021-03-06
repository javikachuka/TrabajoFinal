@extends('admin_panel.index')

@section('content')


<div class="form-group col-md-8">
</div>
<div class="card">
    <div class="card-header">
        <h3>Listado de Productos
            <span></span>
            @can('productos_create')
            <button type="submit" class="btn btn-primary btn-xs"
                onclick="location.href = '{{ route('productos.create') }}'">Nuevo Producto</button>
            @endcan
        </h3>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="productos" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Cantidad Minima</th>
                        <th>Rubro</th>
                        <th>Cantidad Disponible</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)

                    <tr>
                        <td>{{$producto->id}}</td>
                        <td>{{$producto->nombre}}</td>
                        <td style="text-align: right">{{$producto->codigo}}</td>
                        <td style="text-align: right">{{$producto->cantidadMinima}} {{$producto->medida->nombre}}</td>
                        <td>{{$producto->rubro->nombre}}</td>
                        <td style="text-align: right">
                            @if(!$producto->estaEnCantidadMinima())
                            <div class="badge badge-success">{{$producto->cantidadTotal()}}
                                {{$producto->medida->nombre}}</div>
                            @else
                            <div class="badge badge-warning">{{$producto->cantidadTotal()}}
                                {{$producto->medida->nombre}}</div>
                            @endif

                        </td>
                        <td width="18%">
                            @can('productos_show')
                            <a href="{{route('productos.show', $producto)}}" class="btn btn-xs btn-primary">Ver mas</a>
                            @endcan
                            @can('productos_edit')
                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-xs btn-secondary">
                                Editar </a>
                            @endcan
                            @can('productos_destroy')
                            <form id="form-borrar{{$producto->id}}" method="POST"
                                action="{{route('productos.destroy' , $producto->id)}}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs btn-almacen"
                                    id="{{$producto->id}}">Borrar</button>
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
    $(function () {
          $('#productos').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
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
