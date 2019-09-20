@extends('admin_panel.index')

@section('content')

<h1>Listado de Tipo de Reclamos</h1>

    <div class="form-group col-md-8">
        <a href=""  class="btn btn-primary btn-sm " data-toggle="modal" data-target="#crear">Nuevo Tipo de Reclamo</a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tipoReclamos" class="table table-bordered table-striped table-hover datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Detalle</th>
                    <th>Flujo de Trabajo</th>
                    <th>Nivel de Prioridad</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($tipoReclamos as $tipRec)

                        <tr>
                            <td>{{$tipRec->id}}</td>
                            <td>{{$tipRec->nombre}}</td>
                            <td>{{$tipRec->detalle}}</td>
                            <td>
                                @if($tipRec->flujoTrabajo != null)
                                    <span class="badge badge-info">{{$tipRec->flujoTrabajo->nombre}}</span>
                                @else
                                    <span class="badge badge-secondary">Sin Flujo</span>
                                @endif
                            </td>
                            <td> <span class="badge badge-warning"> {{$tipRec->prioridad->nombre}} </span></td>
                            <td width ="95px">
                                @can('tipoReclamos_edit')
                                <a href=""  class="btn btn-secondary btn-xs " data-toggle="modal" data-target="#editar{{$tipRec->id}}" >Editar</a>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editar{{$tipRec->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Estado</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form class="form-group " method="POST" action="/tipoReclamos/{{$tipRec->id}}">
                                        @method('PUT')
                                        <div class="modal-body">
                                                <div class="form-group">
                                                        <label>Nombre</label>
                                                        <input type="text" name="nombre" required value="{{ $tipRec->nombre ?? old('nombre')}}"  class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Detalles</label>
                                                    <textarea name="detalle" class="form-control" id="" cols="10" rows="3">{{$tipRec->detalle}}</textarea>
                                                </div>

                                                <div class="form-group">
                                                        <label>Corresponde a un Trabajo</label>

                                                        <div class="form-group">
                                                                <input type="radio"  id="radYes" value="1" name="trabajo" required @if($tipRec->trabajo == 1) checked @endif> <label for="radYes">SI</label> <br>
                                                                <input type="radio"  id="radNo" value="0" name="trabajo" @if($tipRec->trabajo != 1) checked @endif> <label for="radNo">NO</label>
                                                        </div>

                                                </div>

                                                <div class="form-group">
                                                    <label for="">Flujo de Trabajo</label>
                                                    <select name="flujoTrabajo_id" class="form-control" required >
                                                            <option value="" disabled selected>--Seleccione un Flujo--</option>
                                                            @foreach ($flujosTrabajos as $flujoTrabajo)
                                                                <option value="{{$flujoTrabajo->id}}" @if($tipRec->flujoTrabajo != null) @if ($tipRec->flujoTrabajo->id == $flujoTrabajo->id) selected="selected" @endif @endif>{{$flujoTrabajo->nombre}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Prioridad</label>
                                                    <select name="prioridad_id" class="form-control" required >
                                                        <option value="" disabled selected>--Seleccione una Prioridad--</option>
                                                            @foreach ($prioridades as $prioridad)
                                                                <option value="{{$prioridad->id}}" @if($tipRec->prioridad != null) @if ($tipRec->prioridad->id == $prioridad->id) selected="selected" @endif @endif>{{$prioridad->nombre}}</option>
                                                            @endforeach
                                                    </select>
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
                            <form method="POST" action="tipoReclamos/{{$tipRec->id}}" onsubmit="return confirm('Desea borrar a {{$tipRec->nombre}}')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    @can('tipoReclamos_destroy')
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
            <form class="form-group " method="POST" action="/tipoReclamos">
            <div class="modal-body">
                    <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" required value=""  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Detalles</label>
                        <textarea name="detalle" class="form-control" id="" cols="10" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                            <label>Corresponde a un Trabajo</label>
                            <div class="form-group">
                                <input type="radio" id="radYes" value="1" name="trabajo" required> <label for="radYes">SI</label> <br>

                                <input type="radio"  id="radNo" value="0" name="trabajo"> <label for="radNo">NO</label>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="">Flujo de Trabajo</label>
                        <select name="flujoTrabajo_id" class="form-control" required >
                                <option value="" disabled selected>--Seleccione un Flujo--</option>
                                @foreach ($flujosTrabajos as $flujoTrabajo)
                                    <option value="{{$flujoTrabajo->id}}">{{$flujoTrabajo->nombre}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Prioridad</label>
                        <select name="prioridad_id" class="form-control" required >
                            <option value="" disabled selected>--Seleccione una Prioridad--</option>
                                @foreach ($prioridades as $prioridad)
                                    <option value="{{$prioridad->id}}">{{$prioridad->nombre}}</option>
                                @endforeach
                        </select>
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
          $('#tipoReclamos').DataTable({
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
