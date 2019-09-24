@extends('admin_panel.index')

@section('content')

<h1>Listado de Estados</h1>

    <div class="form-group col-md-8">
        <a href=""  class="btn btn-primary btn-sm " data-toggle="modal" data-target="#crear">Nuevo Estado</a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="estados" class="table table-bordered table-striped table-hover datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($estados as $estado)

                        <tr>
                            <td width = '50px'>{{$estado->id}}</td>
                            <td>{{$estado->nombre}}</td>

                            <td width ="150px">
                                @can('estados_edit')
                                    <a href=""  class="btn btn-secondary btn-xs " data-toggle="modal" data-target="#editar{{$estado->id}}" >Editar</a>
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editar{{$estado->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Nuevo Estado</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <form class="form-group " method="POST" action="/estados/{{$estado->id}}">
                                            @method('PUT')
                                            <div class="modal-body">
                                                    <div class="form-group">
                                                            <label>Nombre</label>
                                                            <input type="text" name="nombre" required value="{{ $estado->nombre ?? old('nombre')}}"  class="form-control">
                                                    </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary btn-sm ">Guardar</button>
                                                </div>
                                            </div>
                                            @csrf
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                @endcan
                                <form method="POST" action="estados/{{$estado->id}}" onsubmit="return confirm('Desea borrar el estado {{$estado->nombre}}')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    @can('estados_destroy')
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


 <!-- Modal Create -->
 <div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Estado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form class="form-group " method="POST" action="/estados">
        <div class="modal-body">
                <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" required value="{{old('nombre')}}"  class="form-control">
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary btn-sm ">Guardar</button>
            </div>
        @csrf
        </form>
    </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
        $(function () {
          $('#estados').DataTable({
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
