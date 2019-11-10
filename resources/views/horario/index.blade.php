@extends('admin_panel.index')

@section('content')



<div class="card">
    <div class="card-header">
        <h3>Horarios <span> </span>
            <a href="" class="btn btn-primary btn-sm " data-toggle="modal" data-target="#crear">Crear</a>
        </h3>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="horarios" class="table  table-striped table-hover datatable">
                <thead>
                    <h4>Listado de Horarios</h4>

                </thead>
                <tbody>
                    @foreach($horarios as $horario)

                    <tr>
                        <td>{{$horario->nombre}}</td>
                        <td>{{$horario->horaEntrada}}</td>
                        <td>{{$horario->horaSalida}}</td>
                        <td width="150px">
                            {{-- @can('horarios_edit') --}}
                            <a href="" class="btn btn-secondary btn-xs " data-toggle="modal"
                                data-target="#editar{{$horario->id}}">Editar</a>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editar{{$horario->id}}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Nuevo Horario</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form class="form-group " method="POST" action="/horarios/{{$horario->id}}">
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Nombre</label>
                                                    <input type="text" name="nombre" required
                                                        value="{{ $horario->nombre ?? old('nombre')}}"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Hora de Entrada</label>
                                                    <input type="time" class="form-control" name="horaEntrada"
                                                        value="{{ $horario->horaEntrada ?? old('horaEntrada')}}"
                                                        required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="    ">Hora de Salida</label>
                                                    <input type="time" class="form-control" name="horaSalida"
                                                        value="{{ $horario->horaSalida ?? old('horaSalida')}}" required>
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
                            {{-- @endcan --}}
                            <form id="form-borrar{{$horario->id}}" method="POST"
                                action="{{route('horarios.destroy' , $horario->id)}}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs btn-almacen"
                                    id="{{$horario->id}}">Borrar</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Horario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-group " method="POST" action="/horarios">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" required value="" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="appt">Hora de Entrada</label>
                        <input type="time" class="form-control" id="appt" name="horaEntrada" required>
                    </div>

                    <div class="form-group">
                        <label for="appt2">Hora de Salida</label>
                        <input type="time" class="form-control" id="appt2" name="horaSalida" required>
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
    @if(session('confirmar'))
            Confirmar.fire() ;
        @elseif(session('cancelar'))
            Cancelar.fire();
        @elseif(session('borrado'))
            Borrado.fire();
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
