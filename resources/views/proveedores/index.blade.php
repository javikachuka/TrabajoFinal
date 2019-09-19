@extends('admin_panel.index')

@section('content')

<h1>Listado de Proveedores</h1>

    <div class="form-group col-md-8">
        <button type="submit" class="btn btn-primary " onclick="location.href = '{{ route('proveedores.create') }}'">Registrar Proveedor</button>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="proveedores" class="table table-bordered table-striped table-hover datatable">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>CUIT</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($proveedores as $proveedor)

                        <tr>
                            <td>{{$proveedor->nombre}}</td>
                            <td>{{$proveedor->cuit}}</td>
                            <td>{{$proveedor->email}}</td>
                            <td>{{$proveedor->telefono}}</td>
                            <td width ="125px">
                                @can('proveedores_edit')
                                    <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-xs btn-secondary"> Editar </a>
                                @endcan
                            <form method="POST" action="proveedores/{{$proveedor->id}}" onsubmit="return confirm('Desea borrar a {{$proveedor->nombre}}')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    @can('proveedores_destroy')
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
          $('#proveedores').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
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
@endpush
