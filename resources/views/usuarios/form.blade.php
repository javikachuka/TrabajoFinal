
<div class="container" >
    <h2>Datos Personales</h2>
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="name" required value="{{ old('nombre') ?? $user->name }}"  class="form-control">
    </div>
    <div class="form-group">
        <label>Apellido</label>
        <input type="text" name="apellido" required value="{{ old('apellido') ?? $user->apellido }}" class="form-control">
    </div>
    <div class="form-group">
        <label>DNI</label>
        <input type="text" name="dni" required value="{{ old('dni') ?? $user->dni }}"   class="form-control">
    </div>
    <div class="form-group">
        <label for="">Fecha de Ingreso <input type="date" name="fecha_ingreso" required value="{{ old('fecha_ingreso') ?? $user->fecha_ingreso }}"  id=""></label>
    </div>
    <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
            <label for="roles">Roles*</label>
            <select name="roles[]" id="roles" class="roles-js form-control" multiple="multiple" required>
                @foreach($roles as $id => $roles)
                    <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                @endforeach
            </select>
            @if($errors->has('roles'))
                <p class="help-block">
                    {{ $errors->first('roles') }}
                </p>
            @endif
    </div>

<div class="form-group">
    <label for="roles">Otro</label>
    <select name="roles[]" id="roles" class="js-example-basic-multiple form-control" multiple="multiple" required>
        <option value="AL">Alabama</option>
        <option value="WY">Wyoming</option>
    </select>
</div>




    <div class="form-group">
        <label>Telefono</label>
        <input type="text" name="telefono" required value="{{ old('telefono') ?? $user->telefono }}"  class="form-control">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" required  value="{{ old('email') ?? $user->email }}"  class="form-control">
    </div>
    <div class="fomr-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
    </div>

    <h3>Domicilio</h3>
    <div class="form-group">
        <select name="barrio_id" class="form-control" >
            <option value="0" selected>--Seleccione un barrio--</option>
                @foreach ($barrios as $barrio)
                    <option value="{{$barrio->id}}">{{$barrio->nombre}}</option>
                @endforeach
        </select>
    </div>
    <div class="form-group">
            <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <div class="form-group">
                            <label for="">Calle</label>
                            <div class="input-group">
                                <input name="calle" type="text"  value="" required class="form-control" placeholder="Calle">
                                <span class="input-group-addon">-</span>
                                <input name="altura"  type="text"  value="" required class="form-control col-md-3" placeholder="Altura">
                            </div>
                        </div>
                    </div>
            </div>
    </div>


</div>
@csrf
@push('scripts')
<script>

    $(document).ready(function() {
        $('.roles-js').select2();
        theme: "classic"
    });

</script>
@endpush
