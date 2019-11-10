@extends('admin_panel.index')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Listado de Socios
            @can('socios_create')
            <a href="{{route('socios.create')}}" class="btn btn-primary btn-xs ">Nuevo Socio</a>
            @endcan
            {{-- <a href="" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#crear" >Nuevo Socio</a> --}}

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
                <th>Nº de Conexion/es</th>
                <th>Direccion</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($socios as $socio)
            <tr>
                <td>{{$socio->apellido}}</td>
                <td>{{$socio->nombre}}</td>
                <td style="text-align: right">{{$socio->dni}}</td>
                <td style="text-align: right">
                    @foreach ($socio->direcciones as $conexion)
                    {{$conexion->nro_conexion}} <br>
                    @endforeach
                </td>

                <td>
                    @foreach ($socio->direcciones as $conexion)
                    {{$conexion->calle}} {{$conexion->altura}}, {{$conexion->zona->nombre}} <br>
                    @endforeach

                </td>

                <td width="15%">
                    @can('socios_edit')
                    <a href="{{route('socios.edit', $socio)}}" class="btn btn-secondary btn-xs ">Editar</a>
                    @endcan

                    @can('socios_destroy')
                    <form id="form-borrar{{$socio->id}}" method="POST" action="{{route('socios.destroy' , $socio)}}"
                        style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-xs btn-almacen"
                            id="{{$socio->id}}">Borrar</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>
</div>
<!-- Modal Create -->
{{-- <div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Socio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-group " method="POST" action="{{route('socios.store')}}">
<div class="modal-body" id="registroSocio">
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
        <input type="text" name="dni" required value="{{  old('dni')}}" class="form-control" data-mask="00.000.000">
        <div class="text-danger">{{$errors->first('dni')}} </div>
    </div>
    <div class="card">
        <div class="card-header">
            Datos de la Conexion
            <div class="card-tools">
                <button type="button" id="agregarConexion" class="btn btn-primary btn-xs">Agregar</button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Nº de Conexion</label>
                <input type="number" name="nro_conexion" required value="{{old('nro_conexion')}}" class="form-control">
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
                <label for="">Zona</label>
                <select name="zona_id" class="form-control" required>
                    <option value="" selected disabled>--Seleccione--</option>
                    @foreach ($zonas as $zona)
                    <option value="{{$zona->id}}">{{$zona->nombre}}</option>
                    @endforeach
                </select>
                <div class="text-danger">{{$errors->first('zona_id')}} </div>
            </div>
        </div>
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
</div> --}}
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

{{-- <script>
    $('#agregarConexion').on('click' ,function(){
        addConexion();
    });

    function addConexion(){

        var fila = '<div class="card" id="con1">'+
                        '<div class="card-header">'+
                           'Datos de la Conexion'+
                            '<div class="card-tools">'+
                               '<a href="#" id="borrarConexion" class="btn btn-danger btn-xs borrarConnexion">Quitar</a>'+
                            '</div>'+
                        '</div>'+
                        '<div class="card-body">'+
                            '<div class="form-group">'+
                                '<label>Nº de Conexion</label>'+
                                '<input type="number" name="nro_conexion" required value="{{old('nro_conexion')}}"'+
'class="form-control">'+
'<div class="text-danger">{{$errors->first('nro_conexion')}} </div>'+
'</div>'+
'<label for="">Direccion</label>'+
'<div class="form-group">'+
    '<div class="row">'+
        '<div class="col-xs-12 col-md-12">'+
            '<div class="form-group">'+
                '<label for="">Calle</label>'+
                '<div class="input-group">'+
                    '<input name="calle" type="text" value="{{  old('calle') }}" required class="form-control"
                        placeholder="Calle">'+
                    '<div class="input-group-prepend">'+
                        '<span class="input-group-text">-</span>'+
                        '</div>'+
                    '<input name="altura" type="text" value="{{ old('altura')}}" required class="form-control col-md-3"
                        placeholder="Altura">'+
                    '</div>'+
                '</div>'+
            ' </div>'+
        '</div>'+
    '</div>'+
'<div class="form-group">'+
    '<label for="">Zona</label>'+
    '<select name="zona_id" class="form-control" required>'+
        '<option value="" selected disabled>--Seleccione--</option>'+
        '@foreach ($zonas as $zona)'+
        '<option value="{{$zona->id}}">{{$zona->nombre}}</option>'+
        '@endforeach'+
        '</select>'+
    '<div class="text-danger">{{$errors->first('zona_id')}} </div>'+
    '</div>'+
' </div>'+
'</div>' ;

$('#crear .modal-body').append(fila) ;


}

$('#registroSocio').on('click', '.borrarConexion' ,function(){
$("#con1").last().remove();
}) ;


</script> --}}

@endpush
