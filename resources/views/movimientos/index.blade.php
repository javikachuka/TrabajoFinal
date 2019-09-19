@extends('admin_panel.index')

@section('content')
    <h2>Movimientos Realizados</h2>
<br>
    <div class="form-group col-md-8">
            <a type="submit" href="{{ route('movimientos.createIngreso') }}" class="btn btn-xs btn-success"> Nuevo Ingreso <i class="fas fa-tags nav-icon"></i></a>
            <a type="submit" href="{{ route('movimientos.createTransferencia') }}" class="btn btn-xs btn-success"> Nueva Transferencia <i class="nav-icon fas fa-exchange-alt"></i></a>
            <a type="submit" href="{{ route('movimientos.pdf') }}" class="btn btn-xs btn-danger ">Generar <i class="fa fa-file-pdf"></i></a>
    </div>
    <div class="form-group col-md-8">
    </div>
    <div class="card">
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
                                <td>{{$movimiento->cabeceraMovimiento->fecha}}</td>
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
                                        <a href="{{ route('movimientos.edit', $movimiento->id) }}" class="btn btn-xs btn-secondary"> Editar </a>
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
    @endif
</script>

@endpush
