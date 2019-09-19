@extends('admin_panel.index')

@section('content')

<h1>Listado de reclamos</h1>

    <div class="form-group col-md-8">
        <button type="submit" class="btn btn-primary " onclick="location.href = '{{ route('reclamos.create') }}'">Nuevo reclamo</button>
    </div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="reclamos" class="table table-bordered table-striped table-hover datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tipo de Reclamo</th>
                    <th>Fecha</th>
                    <th>Socio</th>
                    <th>Detalles</th>
                    <th>Estado</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($reclamos as $reclamo)

                        <tr>
                            <td>{{$reclamo->id}}</td>
                            <td>
                                <span>{{$reclamo->tipoReclamo->nombre}} </span>
                            </td>
                            <td>{{$reclamo->fecha}}</td>
                            <td>{{$reclamo->socio->apellido}} {{$reclamo->socio->nombre}}</td>
                            <td>
                                @if($reclamo->detalle != null)
                                    <span class="badge badge-light"> {{$reclamo->detalle}}</span>
                                @else
                                    <span class="badge badge-light">Sin detalle</span>
                                @endif
                            </td>
                            <td>
                                @if($reclamo->trabajo != null)
                                    <span class="badge badge-info"> {{$reclamo->trabajo->estado->nombre}}</span>
                                @else
                                    <span class="badge badge-light">N/A</span>
                                @endif
                            </td>
                            <td width ="200px">
                                <a href="{{route('reclamos.show', $reclamo)}}" class="btn btn-xs btn-primary">Ver mas</a>
                                @can('trabajos_edit')
                                    <a href="{{ route('reclamos.edit', $reclamo) }}" class="btn btn-xs btn-secondary"> Editar </a>
                                @endcan
                                <form method="POST" action="reclamos/{{$reclamo->id}}" onsubmit="return confirm('Desea borrar el reclamo {{$reclamo->nombre}}')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    @can('reclamos_destroy')
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
          $('#reclamos').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "order": [[ 0, "desc" ]] ,
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
