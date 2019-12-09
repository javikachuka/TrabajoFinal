@extends('admin_panel.index')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <form class="form-group" method="POST" action="{{route('socios.update' , $socio)}}">
                @method('PUT')
                <div class="card-header">
                    <h3>Datos Personales</h3>
                </div>
                <div class="card-body" id="registroSocio">
                    @csrf
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" value="{{ $socio->apellido ?? old('apellido') }}" required
                            class="form-control" placeholder="Ingrese el apellido">
                        <div class="text-danger">{{$errors->first('apellido')}} </div>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="{{$socio->nombre ?? old('nombre')}}"
                            class="form-control" placeholder="Ingrese el nombre" required>
                        <div class="text-danger">{{$errors->first('nombre')}} </div>

                    </div>
                    <div class="form-group">
                        <label>DNI</label>
                        <input type="text" name="dni" value="{{$socio->dni ?? old('dni')}}" class="form-control"
                            placeholder="Ingrese el DNI" required data-mask="00.000.000">
                        <div class="text-danger">{{$errors->first('dni')}} </div>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>
                        <input type="submit" value="Modificar" class="btn btn-success btn-sm">
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Conexiones Asignadas</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nº de Conexion</th>
                            <th>Direccion</th>
                            <th>Accion</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($socio->direcciones as $direc)
                        <tr>
                            <td>{{$direc->nro_conexion}}</td>
                            <td>{{$direc->calle}} {{$direc->altura}}, {{$direc->zona->nombre}}</td>
                            <td>
                                <form id="form-borrar{{$direc->id}}" method="POST"
                                    action="{{route('socios.eliminarConexion' , [$socio->id , $direc->id] )}}"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs btn-socio"
                                        id="{{$direc->id}}">Borrar</button>

                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button type="button" id="agregarConexion" class="btn btn-primary btn-xs" data-toggle="modal"
                        data-target="#crearConexion">Agregar</button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Conexion -->
<div class="modal fade" id="crearConexion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Conexion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-group " method="POST" action="{{route('socios.nuevaConexion')}}">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="socio_id" id="idSocio" value="{{$socio->id}}">
                    </div>
                    <div class="form-group">
                        <label>Nº de Conexion</label>
                        <input type="number" name="nro_conexion" required value="{{old('nro_conexion')}}"
                            class="form-control">
                        <div class="text-danger">{{$errors->first('nro_conexion')}}</div>
                    </div>
                    <label for="">Direccion</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Calle</label>
                                    <div class="input-group">
                                        <input name="calle" type="text" value="{{old('calle')}}" required
                                            class="form-control" placeholder="Calle">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">-</span>
                                        </div>
                                        <input name="altura" type="text" value="{{old('altura')}}" required
                                            class="form-control col-md-3" placeholder="Altura">
                                    </div>
                                    <div class="text-danger">{{$errors->first('altura')}} </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Zona</label>
                        <select name="zona_id" class="form-control" required>
                            <option value="" selected disabled>--Seleccione--</option>
                            @foreach ($zonas as $zona)
                            <option value="{{$zona->id}}" @if($zona->id == old('zona_id')) selected
                                @endif>{{$zona->nombre}}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">{{$errors->first('zona_id')}} </div>
                    </div>
                </div>
                <input type="hidden" name="modal" id="modalAbierto" value="">
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
    @if($errors->has('nro_conexion') )
        $(function(){
            $('#crearConexion').modal('show');
        });
    @endif
    @if($errors->has('altura') )
        $(function(){
            $('#crearConexion').modal('show');
        });
    @endif
</script>

<script>
    $('.btn-socio').on('click', function(e){
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
