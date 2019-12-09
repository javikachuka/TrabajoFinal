@extends('admin_panel.index')

@section('content')

<div class="card">
    <form class="form-group" method="POST" action="{{route('socios.atajo')}}">
        <div class="card-header">
            <h3>Registro de Socios</h3>

        </div>
        <div class="card-body" id="registroSocio">
            <h4>Datos Personales</h4>
            <div class="form-group">
                <label>Apellido</label>
                <input type="text" name="apellido" id="apellido" value="{{old('apellido')}}" required class="form-control"
                    placeholder="Ingrese el apellido">
                <div class="text-danger">{{$errors->first('apellido')}} </div>
            </div>
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{old('nombre')}}" class="form-control"
                    placeholder="Ingrese el nombre" required>
                <div class="text-danger">{{$errors->first('nombre')}} </div>

            </div>
            <div class="form-group">
                <label>DNI</label>
                <input type="text" name="dni" value="{{old('dni')}}" class="form-control" placeholder="Ingrese el DNI"
                    required data-mask="00.000.000">
                <div class="text-danger">{{$errors->first('dni')}} </div>

            </div>
            <br>
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
                        <input type="number" name="nro_conexion[]" required value="{{old('nro_conexion.0')}}"
                            class="form-control">
                        <div class="text-danger">{{$errors->first('nro_conexion.0')}}</div>
                    </div>
                    <label for="">Direccion</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Calle</label>
                                    <div class="input-group">
                                        <input name="calle[]" type="text" value="{{old('calle.0')}}" required
                                            class="form-control" placeholder="Calle">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">-</span>
                                        </div>
                                        <input name="altura[]" type="text" value="{{old('altura.0')}}" required
                                            class="form-control col-md-3" placeholder="Altura">

                                    </div>
                                    <div class="text-danger">{{$errors->first('altura.0')}} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Zona</label>
                        <select name="zona_id[]" class="form-control" required>
                            <option value="" selected disabled>--Seleccione--</option>
                            @foreach ($zonas as $zona)
                            <option value="{{$zona->id}}" @if($zona->id == old('zona_id.0')) selected
                                @endif>{{$zona->nombre}}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">{{$errors->first('zona_id')}} </div>
                    </div>
                </div>
            </div>


            @if((count($errors->get('nro_conexion.*')) > 1) || session('cant') > 1 )
            {{-- @foreach ($errors->get('images'.*) as $error)
                    <li>{{ $error }}</li>
            @endforeach --}}
            @for ($i = 1; $i < session('cant'); $i++) <div class="card" id="con1">
                <div class="card-header">
                    Datos de la Conexion
                    <div class="card-tools">
                        <button type="button" id="borrarConexion"
                            class="btn btn-danger btn-xs borrarConexion">Quitar</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nº de Conexion</label>
                        <input type="number" name="nro_conexion[]" required value="{{old('nro_conexion.'.$i)}}"
                            class="form-control">
                        <div class="text-danger">{{$errors->first('nro_conexion.'.$i)}}</div>
                    </div>
                    <label for="">Direccion</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Calle</label>
                                    <div class="input-group">
                                        <input name="calle[]" type="text" value="{{old('calle.'.$i)}}" required
                                            class="form-control" placeholder="Calle">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">-</span>
                                        </div>
                                        <input name="altura[]" type="text" value="{{old('altura.'.$i)}}" required
                                            class="form-control col-md-3" placeholder="Altura">
                                    </div>
                                    <div class="text-danger">{{$errors->first('altura.'.$i)}}</div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Zona</label>
                        <select name="zona_id[]" class="form-control" required>
                            <option value="" selected disabled>--Seleccione--</option>
                            @foreach ($zonas as $zona)
                            <option value="{{$zona->id}}" @if($zona->id == old('zona_id.'.$i)) selected
                                @endif>{{$zona->nombre}}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">{{$errors->first('zona_id')}} </div>
                    </div>
                </div>
        </div>
        @endfor
        @endif
</div>
<div class="card-footer">
    <div class="text-right">
        <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm">
        <input type="submit" value="Cargar Socio" class="btn btn-success btn-sm">
    </div>
</div>
@csrf
</form>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
            $('#nombre').mask('Z',{translation: {'Z': {pattern: /[ña-zÑA-Z ]/, recursive: true}}});
            $('#apellido').mask('Z',{translation: {'Z': {pattern: /[ña-zÑA-Z ]/, recursive: true}}});
        });
</script>
<script>
    $('#agregarConexion').on('click' ,function(){
            addConexion();
        });

        function addConexion(){

            var fila = '<div class="card" id="con1">'+
                            '<div class="card-header">'+
                               'Datos de la Conexion'+
                                '<div class="card-tools">'+
                                   '<a href="#" id="borrarConexion" class="btn btn-danger btn-xs borrarConexion">Quitar</a>'+
                                '</div>'+
                            '</div>'+
                            '<div class="card-body">'+
                                '<div class="form-group">'+
                                    '<label>Nº de Conexion</label>'+
                                    '<input type="number" name="nro_conexion[]" required value=""'+
                                        'class="form-control">'+
                                    '<div class="text-danger"> </div>'+
                                '</div>'+
                                '<label for="">Direccion</label>'+
                                '<div class="form-group">'+
                                    '<div class="row">'+
                                        '<div class="col-xs-12 col-md-12">'+
                                            '<div class="form-group">'+
                                                '<label for="">Calle</label>'+
                                                '<div class="input-group">'+
                                                    '<input name="calle[]" type="text" value="" required class="form-control" placeholder="Calle">'+
                                                    '<div class="input-group-prepend">'+
                                                        '<span class="input-group-text">-</span>'+
                                                    '</div>'+
                                                    '<input name="altura[]" type="text" value="" required class="form-control col-md-3" placeholder="Altura">'+
                                                '</div>'+
                                            '</div>'+
                                       ' </div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label for="">Zona</label>'+
                                    '<select name="zona_id[]" class="form-control" required>'+
                                        '<option value="" selected disabled>--Seleccione--</option>'+
                                        '@foreach ($zonas as $zona)'+
                                        '<option value="{{$zona->id}}">{{$zona->nombre}}</option>'+
                                        '@endforeach'+
                                    '</select>'+
                                    '<div class="text-danger"> </div>'+
                                '</div>'+
                           ' </div>'+
                        '</div>' ;

            $('#registroSocio').append(fila) ;


        }

        $('#registroSocio').on('click', '.borrarConexion' ,function(){
            $("#con1").last().remove();
        }) ;


</script>

@endpush
