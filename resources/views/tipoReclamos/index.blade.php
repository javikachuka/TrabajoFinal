@extends('admin_panel.index')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Listado de Tipo de Reclamos
            @can('tipoReclamos_create')
            <a href="" class="btn btn-primary btn-xs " data-toggle="modal" data-target="#crear">Nuevo Tipo de
                Reclamo</a>
            @endcan

        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tipoReclamos" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Detalle</th>
                        <th>Requisitos</th>
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
                            <ul>
                                @foreach ($tipRec->requisitos as $req)
                                <li>{{$req->nombre}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if($tipRec->flujoTrabajo != null)
                            <span class="badge badge-info">{{$tipRec->flujoTrabajo->nombre}}</span>
                            @else
                            <span class="badge badge-secondary">Sin Flujo</span>
                            @endif
                        </td>
                        <td> <span class="badge badge-warning"> {{$tipRec->prioridad->nombre}} </span></td>
                        <td width="95px">
                            @can('tipoReclamos_edit')
                            <a href="" class="btn btn-secondary btn-xs " data-toggle="modal"
                                data-target="#editar{{$tipRec->id}}">Editar</a>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editar{{$tipRec->id}}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edicion de Tipo de Reclamo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form class="form-group " method="POST" action="/tipoReclamos/{{$tipRec->id}}">
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Nombre</label>
                                                    <input type="text" name="nombre" required
                                                        value="{{ $tipRec->nombre ?? old('nombre')}}"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Detalles</label>
                                                    <textarea name="detalle" class="form-control" id="" cols="10"
                                                        rows="3">{{$tipRec->detalle}}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Corresponde a un Trabajo</label>

                                                    <div class="form-group">
                                                        <input type="radio" id="radYes" value="1" name="trabajo"
                                                            required @if($tipRec->trabajo == 1) checked @endif> <label
                                                            for="radYes">SI</label> <br>
                                                        <input type="radio" id="radNo" value="0" name="trabajo"
                                                            @if($tipRec->trabajo != 1) checked @endif> <label
                                                            for="radNo">NO</label>
                                                    </div>

                                                </div>


                                                <div class="form-group">
                                                    <label for="">Requisitos Necesarios</label> <br>
                                                    @foreach ($requisitos as $requisito)
                                                    <input type="checkbox" id="checkaa{{$requisito->id}}"
                                                        value="{{$requisito->id}}" name="requisitos[]"
                                                        @if($tipRec->requisitos->contains($requisito)) checked @endif>
                                                    <label
                                                        for="checkaa{{$requisito->id}}">{{$requisito->nombre}}</label>
                                                    <br>

                                                    @endforeach
                                                </div>





                                                <div class="form-group">
                                                    <label for="">Flujo de Trabajo</label>
                                                    <select name="flujoTrabajo_id" class="form-control" required>
                                                        <option value="" disabled selected>--Seleccione un Flujo--
                                                        </option>
                                                        @foreach ($flujosTrabajos as $flujoTrabajo)
                                                        <option value="{{$flujoTrabajo->id}}" @if($tipRec->flujoTrabajo
                                                            != null) @if ($tipRec->flujoTrabajo->id ==
                                                            $flujoTrabajo->id) selected="selected" @endif
                                                            @endif>{{$flujoTrabajo->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Prioridad</label>
                                                    <select name="prioridad_id" class="form-control" required>
                                                        <option value="" disabled selected>--Seleccione una Prioridad--
                                                        </option>
                                                        @foreach ($prioridades as $prioridad)
                                                        <option value="{{$prioridad->id}}" @if($tipRec->prioridad !=
                                                            null) @if ($tipRec->prioridad->id == $prioridad->id)
                                                            selected="selected" @endif @endif>{{$prioridad->nombre}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary btn-sm ">Guardar</button>
                                            </div>
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endcan
                            @can('tipoReclamos_destroy')
                            <form id="form-borrar{{$tipRec->id}}" method="POST"
                                action="{{route('tipoReclamos.destroy' , $tipRec->id)}}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs btn-almacen"
                                    id="{{$tipRec->id}}">Borrar</button>
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

<!-- Modal Create -->
<div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Tipo de Reclamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-group " method="POST" action="/tipoReclamos">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        {{--style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase(); --}}
                        <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control">
                        <div class="text-danger">{{$errors->first('nombre')}} </div>
                    </div>
                    <div class="form-group">
                        <label for="">Detalles</label>
                        <textarea name="detalle" class="form-control" id="" cols="10" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Corresponde a un Trabajo</label>
                        <div class="form-group">
                            <input type="radio" id="radYes" value="1" name="trabajo" required> <label
                                for="radYes">SI</label> <br>

                            <input type="radio" id="radNo" value="0" name="trabajo"> <label for="radNo">NO</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Requisitos Necesarios</label>
                        @foreach ($requisitos as $requisito)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="requisitos[]" class="custom-control-input"
                                id="checked2{{$requisito->id}}" value="{{$requisito->id}}">
                            <label class="custom-control-label"
                                for="checked2{{$requisito->id}}">{{$requisito->nombre}}</label>
                        </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="">Flujo de Trabajo</label>
                        <select name="flujoTrabajo_id" class="form-control" required>
                            <option value="" disabled selected>--Seleccione un Flujo--</option>
                            @foreach ($flujosTrabajos as $flujoTrabajo)
                            <option value="{{$flujoTrabajo->id}}">{{$flujoTrabajo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Prioridad</label>
                        <select name="prioridad_id" class="form-control" required>
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
            language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
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
<script>
    @if($errors->any() )
            $(function(){
                $('#crear').modal('show');
            });
        @endif
</script>
<script>
    $('.btn-almacen').on('click', function(e){
                var id = $(this).attr('id');
            e.preventDefault();

        swal({
                title: "Cuidado!",
                text: "Esta seguro que desea eliminar?",
                icon: "warning",
                dangerMode: true,

                buttons: {
                cancel: "Cancelar",
                confirm: "Aceptar",
                },
            })
            .then ((willDelete) => {
                if (willDelete) {
                $("#form-borrar"+id).submit();
                }
            });
         });
</script>
@endpush
