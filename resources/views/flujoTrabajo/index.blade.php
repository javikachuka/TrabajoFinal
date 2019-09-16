@extends('admin_panel.index')

@section('content')
<h1>Listado de Flujos de Trabajos</h1>


<div class="form-group col-md-8">
        <button type="submit" class="btn btn-primary " onclick="location.href = '{{ route('flujoTrabajos.create') }}'">Nuevo Flujo</button>
    </div>
    <div class="card">
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
                            <td width ="200px">
                                @can('flujoTrabajos_edit')
                                    <a href="{{ route('transiciones.create', $flujoTrabajo)}}" class="btn btn-xs btn-secondary"> Editar </a>
                                @endcan
                            <form method="POST" action="{{route('flujoTrabajos.destroy' , $flujoTrabajo)}}" onsubmit="return confirm('Desea borrar {{$flujoTrabajo->nombre}}')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    @can('flujoTrabajos_destroy')
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
