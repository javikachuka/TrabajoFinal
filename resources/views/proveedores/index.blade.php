@extends('admin_panel.index')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Listado de Proveedores <span></span>
            @can('proveedores_create')
            <button type="submit" class="btn btn-primary btn-xs"
                onclick="location.href = '{{ route('proveedores.create') }}'">Registrar Proveedor</button>
            @endcan
            <button type="button" class="btn btn-xs btn-danger "
                onclick="location.href = '{{ route('proveedor.pdf')}}'">Generar <i class="fa fa-file-pdf"></i></button>
        </h3>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="proveedores" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>CUIT</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Productos Ofrecidos</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proveedores as $proveedor)

                    <tr>
                        <td>{{$proveedor->nombre}}</td>
                        <td style="text-align: right">{{$proveedor->cuit}}</td>
                        <td>{{$proveedor->email}}</td>
                        <td style="text-align: right">{{$proveedor->telefono}}</td>
                        <td>
                            @foreach ($proveedor->productos as $p)
                                <div class="badge badge-success">{{$p->nombre}}</div>
                            @endforeach
                        </td>
                        <td width="125px">
                            @can('proveedores_edit')
                            <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-xs btn-secondary">
                                Editar </a>
                            @endcan
                            @can('proveedores_destroy')
                            <form id="form-borrar{{$proveedor->id}}" method="POST"
                                action="{{route('proveedores.destroy' , $proveedor->id)}}"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs btn-almacen"
                                    id="{{$proveedor->id}}">Borrar</button>
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
          $('#proveedores').DataTable({
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
