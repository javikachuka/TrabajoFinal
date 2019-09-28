@extends('admin_panel.index')

@section('content')

<h1>Listado de Almacenes</h1>

    <div class="form-group col-md-8">
            <a href=""  class="btn btn-primary btn-sm " data-toggle="modal" data-target="#crear">Nuevo almacen</a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="almacenes" class="table table-bordered table-striped table-hover datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Denominacion</th>
                    <th>Direccion</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($almacenes as $almacen)

                        <tr>
                            <td>{{$almacen->id}}</td>
                            <td>{{$almacen->denominacion}}</td>
                            <td><p>{{$almacen->direccion->calle}} {{$almacen->direccion->altura}}, {{$almacen->direccion->zona->nombre}}</p></td>
                            <td width ="150px">
                                <a href="{{route('almacenes.show', $almacen)}}" class="btn btn-xs btn-primary">Ver mas</a>
                                @can('almacenes_edit')
                                    <a href=""  class="btn btn-secondary btn-xs " data-toggle="modal" data-target="#editar{{$almacen->id}}" >Editar</a>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editar{{$almacen->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Nuevo Estado</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <form class="form-group " method="POST" action="{{route('almacenes.update' , $almacen->id)}}">
                                            @method('PUT')
                                            <div class="modal-body">
                                                    <div class="form-group">
                                                            <label>Denominacion</label>
                                                            <input type="text" name="denominacion" required value="{{ $almacen->denominacion ?? old('denominacion')}}"  class="form-control">
                                                    </div>

                                                    <label for="">Direccion</label>
                                                    <div class="form-group">
                                                            <select name="zona_id" class="form-control" required >
                                                                    @foreach ($zonas as $zona)
                                                                        <option value="{{$zona->id}}" @if ($zona->id == $almacen->direccion->zona->id) selected="selected" @endif>{{$zona->nombre}}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-xs-12 col-md-8">
                                                                            <div class="form-group">
                                                                                <label for="">Calle</label>
                                                                                <div class="input-group">
                                                                                    <input name="calle" type="text"  value="{{ $almacen->direccion->calle ?? old('calle') }}" required class="form-control" placeholder="Calle">
                                                                                    <span class="input-group-addon">-</span>
                                                                                    <input name="altura"  type="text" value="{{$almacen->direccion->altura ?? old('altura')}}  " required class="form-control col-md-3" placeholder="Altura">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </div>
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
                            <form method="POST" action="almacenes/{{$almacen->id}}" onsubmit="return confirm('Desea borrar {{$almacen->denominacion}}')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')

                                    @can('almacenes_destroy')
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
              <h5 class="modal-title" id="exampleModalLabel">Nuevo Almacen</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-group " method="POST" action="/almacenes">

            <div class="modal-body">
                      <div class="form-group">
                              <label>Denominacion</label>
                              <input type="text" name="denominacion" required value=""  class="form-control">
                      </div>

                      <label for="">Direccion</label>
                            <div class="form-group">
                                    <div class="row">
                                            <div class="col-xs-12 col-md-8">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input name="calle" type="text"  value="{{ old('calle') }}" required class="form-control" placeholder="Calle">
                                                        <span class="input-group-addon">-</span>
                                                        <input name="altura"  type="text" value="{{ old('altura') }}" required class="form-control col-md-3" placeholder="Altura">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                            <label for="">Zona</label>
                            <div class="form-group">
                                <select name="zona_id" class="form-control" required >
                                        @foreach ($zonas as $zona)
                                            <option value="{{$zona->id}}">{{$zona->nombre}}</option>
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
          $('#almacenes').DataTable({
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
