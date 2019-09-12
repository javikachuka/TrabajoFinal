@extends('admin_panel.index')

@section('content')

<h1>Listado de Productos</h1>

    <div class="form-group col-md-8">
        <button type="submit" class="btn btn-primary " onclick="location.href = '{{ route('productos.create') }}'">Nuevo Producto</button>
    </div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="productos" class="table table-bordered table-striped table-hover datatable">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Codigo</th>
                    <th>Cantidad Total</th>
                    <th>Categoria</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)

                        <tr>
                            <td>{{$producto->nombre}}</td>
                            <td>{{$producto->codigo}}</td>
                            <td>{{$producto->cantidadTotal()}}</td>
                            <td>{{$producto->rubro->nombre}}</td>
                            <td width ="200px">
                                <a href="{{route('productos.show', $producto)}}" class="btn btn-xs btn-primary">Ver mas</a>
                                @can('proveedores_edit')
                                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-xs btn-secondary"> Editar </a>
                                @endcan
                                <form method="POST" action="productos/{{$producto->id}}" onsubmit="return confirm('Desea borrar a {{$producto->nombre}}')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    @can('proveedores_destroy')
                                        <button type="submit" class="btn btn-sm btn-danger btn-xs btn-delete">Borrar</button>
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
          $('#productos').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
          });
        });
</script>
@endpush
