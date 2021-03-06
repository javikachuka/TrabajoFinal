@extends('admin_panel.index')

@section('content')

<form class="form-group " method="POST" action="{{route('users.update' , $user->id)}}" enctype="multipart/form-data">
    @method('PUT')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card ">
                        <div class="card-header">
                            <h3>Edicion de Empleados</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" required value="{{ old('nombre') ?? $user->name }}"
                                    class="form-control">
                                <div class="text-danger">{{$errors->first('name')}} </div>

                            </div>
                            <div class="form-group">
                                <label>Apellido</label>
                                <input type="text" name="apellido" required
                                    value="{{ old('apellido') ?? $user->apellido }}" class="form-control">
                                <div class="text-danger">{{$errors->first('apellido')}} </div>

                            </div>
                            <div class="form-group">
                                <label>DNI</label>
                                <input type="text" id="dni" name="dni" required value="{{ old('dni') ?? $user->dni }}"
                                    class="form-control">
                                <div class="text-danger">{{$errors->first('dni')}} </div>

                            </div>
                            <div class="form-group">
                                <label for="">Fecha de Ingreso <input type="date" name="fecha_ingreso"
                                        class="form-control" required
                                        value="{{ old('fecha_ingreso') ?? $user->fecha_ingreso }}" id=""
                                        max="{{ Carbon\Carbon::now()->format('Y-m-d') }}"></label>
                            </div>

                            <div class="form-group">
                                <label for="fotoUser">Foto del Empleado</label>
                                <input type="file" class="form-control-file" name="urlFoto"
                                    value="{{ old('urlFoto') ?? $user->urlFoto }}" id="fotoUser">
                            </div>
                            <div class="form-group">
                                <label>Telefono</label>
                                <input type="text" name="telefono" required
                                    value="{{ old('telefono') ?? $user->telefono }}" class="form-control">
                                <div class="text-danger">{{$errors->first('telefono')}} </div>

                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" required value="{{ old('email') ?? $user->email }}"
                                    class="form-control">
                                <div class="text-danger">{{$errors->first('email')}} </div>

                            </div>
                            <div class="form-group">
                                <label>Nueva Contraseña</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                                <label for="roles">Roles</label>
                                <select name="roles[]" id="roles" class="roles-js form-control" multiple="multiple"
                                    required>
                                    @foreach($roles as $id => $roles)
                                    <option value="{{ $id }}"
                                        {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                                        {{ $roles }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('roles'))
                                <p class="help-block">
                                    {{ $errors->first('roles') }}
                                </p>
                                @endif
                            </div>


                            <h3>Domicilio</h2>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-8">
                                            <div class="form-group">
                                                <label for="">Calle</label>
                                                <div class="input-group">
                                                    <input name="calle" type="text" @if($user->direccion != null)
                                                    value="{{ old('calle') ?? $user->direccion->calle}} @endif" required
                                                    class="form-control" placeholder="Calle">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">-</span>
                                                    </div>
                                                    <input name="altura" type="text" @if($user->direccion != null)
                                                    value="{{ old('altura') ?? $user->direccion->altura}} @endif"
                                                    required class="form-control col-md-3" placeholder="Altura">
                                                </div>
                                                <div class="text-danger">{{$errors->first('altura')}} </div>
                                                <div class="text-danger">{{$errors->first('calle')}} </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label for="">Zona</label>
                                <div class="form-group">
                                    <select name="zona_id" class="form-control" required>
                                        @foreach ($zonas as $zona)
                                        <option value="{{$zona->id}}" @if($user->direccion != null) @if ($zona->id ==
                                            $user->direccion->zona->id) selected="selected" @endif
                                            @endif>{{$zona->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>

                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>
                                <button type="submit" class="btn btn-success btn-sm">Modificar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @csrf
</form>

@endsection
@push('scripts')
<script>
    $(document).ready(function(){
            $('#dni').mask('00.000.000');
            $('#nombre').mask('Z',{translation: {'Z': {pattern: /[ña-zÑA-Z ]/, recursive: true}}});
            $('#apellido').mask('Z',{translation: {'Z': {pattern: /[ña-zÑA-Z ]/, recursive: true}}});
        });
</script>
<script>
    $(document).ready(function() {
            $('.roles-js').select2();
            theme: "classic"
        });

</script>
@endpush
