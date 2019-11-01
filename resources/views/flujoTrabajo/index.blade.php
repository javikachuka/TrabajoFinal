@extends('admin_panel.index')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Listado de Flujos de Trabajos
            @can('flujoTrabajos_create')
            <button type="submit" class="btn btn-primary btn-xs"
                onclick="location.href = '{{ route('flujoTrabajos.create') }}'">Nuevo Flujo</button>
            @endcan
        </h3>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="flujoTrabajos" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Nrº</th>
                        <th>Nombre</th>
                        <th>Transiciones</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($flujoTrabajos as $flujoTrabajo)

                    <tr>
                        <td>{{$flujoTrabajo->id}}</td>
                        <td>{{$flujoTrabajo->nombre}}</td>
                        <td>
                            @if(!empty($flujoTrabajo->transiciones))
                            @foreach ($flujoTrabajo->transiciones as $t)
                            <span class="badge badge-info">{{$t->nombre}}</span>
                            @endforeach
                            @endif

                        </td>
                        <td width="200px">
                            @can('flujoTrabajos_show')
                            <a href="{{route('flujoTrabajos.show', $flujoTrabajo)}}" class="btn btn-xs btn-primary">Ver
                                mas</a>
                            @endcan

                            @can('flujoTrabajos_edit')
                            <a href="{{ route('flujoTrabajos.edit', $flujoTrabajo)}}" class="btn btn-xs btn-secondary">
                                Editar </a>
                            @endcan
                            @can('flujoTrabajos_destroy')
                            <form method="POST" action="{{route('flujoTrabajos.destroy' , $flujoTrabajo)}}"
                                onsubmit="return confirm('Desea borrar {{$flujoTrabajo->nombre}}')"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <input value="Borrar" type="submit" class="btn btn-sm btn-danger btn-xs btn-delete">
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
          $('#flujoTrabajos').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
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
