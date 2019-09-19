@extends('admin_panel.index')

@section('content')

<h1>Listado de Trabajos</h1>

    <div class="form-group col-md-8">
        <button type="submit" class="btn btn-primary " onclick="location.href = '{{ route('trabajos.create') }}'">Nuevo Trabajo</button>
    </div>
<div class="card">
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
                            <td>{{$trabajo->fecha}}</td>
                            <td><p>{{$trabajo->reclamo->socio->direccion->calle}} {{$trabajo->reclamo->socio->direccion->altura}} , {{$trabajo->reclamo->socio->direccion->zona->nombre}}</p> </td>
                            <td><span class="badge badge-warning">{{$trabajo->reclamo->tipoReclamo->prioridad->nombre}}</span></td>
                            <td>
                                @if($trabajo->estado != null)
                                    <span class="badge badge-info"> {{$trabajo->estado->nombre}}</span>
                                @else
                                    <span class="badge badge-light">N/A</span>
                                @endif
                            </td>
                            <td width ="200px">
                                <a href="{{route('trabajos.show', $trabajo)}}" class="btn btn-xs btn-primary">Ver mas</a>
                                @can('trabajos_edit')
                                    <a href="{{ route('trabajos.edit', $trabajo->id) }}" class="btn btn-xs btn-secondary"> Editar </a>
                                @endcan
                                <a href="{{route('trabajos.inicio' , $trabajo)}}" class="btn btn-xs btn-success"> Iniciar <i class="fad fa-play"></i> </a>

                                {{-- <form method="POST" action="trabajos/{{$trabajo}}" onsubmit="return confirm('Desea borrar el trabajo {{$trabajo->nombre}}')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    @can('trabajos_destroy')
                                        <button type="submit" class="btn btn-sm btn-danger btn-xs btn-delete">Borrar</button>
                                    @endcan
                                </form> --}}
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
          $('#trabajos').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "order": [[ 0, "desc" ]] ,
          });
        });
</script>

@endpush
