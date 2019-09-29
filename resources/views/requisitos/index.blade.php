@extends('admin_panel.index')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>Listado de requisitos <span></span> <a href=""  class="btn btn-primary btn-sm " data-toggle="modal" data-target="#crear">Nuevo Requisito</a>
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="requisitos" class="table table-bordered table-striped table-hover datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($requisitos as $requisito)

                        <tr>
                            <td>{{$requisito->id}}</td>
                            <td>{{$requisito->nombre}}</td>
                            <td>{{$requisito->descripcion}}</td>
                            <td width ="150px">
                                @can('requisitos_edit')
                                    <a href=""  class="btn btn-secondary btn-xs " data-toggle="modal" data-target="#editar{{$requisito->id}}" >Editar</a>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editar{{$requisito->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edicion de Requisito</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <form class="form-group " method="POST" action="{{route('requisitos.update' , $requisito)}}">
                                            @method('PUT')
                                            <div class="modal-body">
                                                    <div class="form-group">
                                                            <label>Nombre</label>
                                                            <input type="text" name="nombre" required value="{{ $requisito->nombre ?? old('nombre')}}"  class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Descripcion</label>
                                                        <textarea name="descripcion" value="{{ $requisito->nombre ?? old('nombre')}}" class="form-control" id="" cols="10" rows="3"></textarea>
                                                    </div>
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
                                @endcan
                            <form method="POST" action="{{route('requisitos.destroy' , $requisito)}}" onsubmit="return confirm('Desea borrar {{$requisito->nombre}}')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')

                                    @can('requisitos_destroy')
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
              <h5 class="modal-title" id="exampleModalLabel">Nuevo requisito</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-group " method="POST" action="{{route('requisitos.store')}}">

                <div class="modal-body">
                        <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="nombre" required value=""  class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Descripcion</label>
                            <textarea name="descripcion" class="form-control" id="" cols="10" rows="3"></textarea>
                        </div>
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
          $('#requisitos').DataTable({
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
