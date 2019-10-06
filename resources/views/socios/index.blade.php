@extends('admin_panel.index')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Listado de Socios
            <a href="" class="btn btn-primary btn-xs " data-toggle="modal" data-target="#crear">Nuevo Socio</a>
        </h3>
        {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif --}}
</div>
<div class="card-body">
    <table id="socios" class="table table-bordered table-striped table-hover datatable">
        <thead>
            <tr>
                <th>Apellido</th>
                <th>Nombre/s</th>
                <th>DNI</th>
                <th>Nro de Conexion</th>
                <th>Direccion</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($socios as $socio)
            <tr>
                <td>{{$socio->apellido}}</td>
                <td>{{$socio->nombre}}</td>
                <td>{{$socio->dni}}</td>
                <td>{{$socio->nro_conexion}}</td>

                <td>{{$socio->direccion->calle}} {{$socio->direccion->altura}}, {{$socio->direccion->zona->nombre}}
                </td>

                <td width="15%">
                    <a href="" class="btn btn-secondary btn-xs " data-toggle="modal"
                        data-target="#editar{{$socio->id}}">Editar</a>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editar{{$socio->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edicion de Socio</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="form-group " method="POST" action="{{route('socios.update' , $socio)}}">
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Apellido</label>
                                            <input type="text" name="apellido" required
                                                value="{{ $socio->apellido ?? old('apellido')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre/s</label>
                                            <input type="text" name="nombre" required
                                                value="{{ $socio->nombre ?? old('nombre')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>DNI</label>
                                            <input type="text" name="dni" required
                                                value="{{ $socio->dni ?? old('dni')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Nº de Conexion</label>
                                            <input type="text" name="nro_conexion" required
                                                value="{{ $socio->nro_conexion ?? old('nro_conexion')}}"
                                                class="form-control">
                                        </div>
                                        <label for="">Direccion</label>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-8">
                                                    <div class="form-group">
                                                        <label for="">Calle</label>
                                                        <div class="input-group">
                                                            <input name="calle" type="text"
                                                                value="{{ $socio->direccion->calle ?? old('calle') }}"
                                                                required class="form-control" placeholder="Calle">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">-</span>
                                                            </div>
                                                            <input name="altura" type="text"
                                                                value="{{$socio->direccion->altura ?? old('altura')}}"
                                                                required class="form-control col-md-3"
                                                                placeholder="Altura">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <select name="zona_id" class="form-control" required>
                                                @foreach ($zonas as $zona)
                                                <option value="{{$zona->id}}" @if ($zona->id ==
                                                    $socio->direccion->zona->id) selected="selected"
                                                    @endif>{{$zona->nombre}}</option>
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

                    <form method="POST" action="{{route('socios.destroy', $socio)}}"
                        onsubmit="return confirm('Desea borrar {{$socio->nombre}}')" style="display: inline-block;">
                        @csrf
                        @method('DELETE')

                        @can('socios_destroy')
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
<!-- Modal Create -->
<div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Socio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-group " method="POST" action="{{route('socios.store')}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" required value="{{ old('apellido')}}" class="form-control">
                        <div class="text-danger">{{$errors->first('apellido')}} </div>
                    </div>
                    <div class="form-group">
                        <label>Nombre/s</label>
                        <input type="text" name="nombre" required value="{{  old('nombre')}}" class="form-control">
                        <div class="text-danger">{{$errors->first('nombre')}} </div>
                    </div>
                    <div class="form-group">
                        <label>DNI</label>
                        <input type="text" name="dni" required value="{{  old('dni')}}" class="form-control">
                        <div class="text-danger">{{$errors->first('dni')}} </div>
                    </div>
                    <div class="form-group">
                        <label>Nº de Conexion</label>
                        <input type="text" name="nro_conexion" required value="{{old('nro_conexion')}}"
                            class="form-control">
                        <div class="text-danger">{{$errors->first('nro_conexion')}} </div>
                    </div>
                    <label for="">Direccion</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Calle</label>
                                    <div class="input-group">
                                        <input name="calle" type="text" value="{{  old('calle') }}" required
                                            class="form-control" placeholder="Calle">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">-</span>
                                        </div>
                                        <input name="altura" type="text" value="{{ old('altura')}}" required
                                            class="form-control col-md-3" placeholder="Altura">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <select name="zona_id" class="form-control" required>
                            <option value="" selected disabled>--Seleccione--</option>
                            @foreach ($zonas as $zona)
                                <option value="{{$zona->id}}" }>{{$zona->nombre}}</option>
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
    $(function () {
          $('#socios').DataTable({
            "order": [[ 0, "desc" ]] ,
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
    @if($errors->any() )
        $(function(){
            $('#crear').modal('show');
        });
    @endif
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
