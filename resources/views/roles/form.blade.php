<div class="form-group">
    <label>Nombre</label>
    <input type="text" name="name" value="{{ old('name') ?? $rol->name }}" class="form-control" required>
    <div>{{$errors->first('name')}} </div>
</div>
<div class="form-group">
    <label>Slug</label>
    <input type="text" name="slug" value="{{ old('slug') ?? $rol->slug }}" class="form-control" required>
    <div>{{$errors->first('slug')}} </div>
</div>
<div class="form-group">
    <label>Descripcion</label>
    <input type="text" name="description" value="{{ old('description') ?? $rol->description }}" class="form-control"
        required>
    <div>{{$errors->first('description')}} </div>
</div>

<div class="form-group">
    <label>Permisos Especiales</label>

    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" id="defaultGroupExample1" value="all-access" name="special"
            @if($rol->special != null) @if($rol->special == 'all-access') checked @endif @endif>
        <label class="custom-control-label" for="defaultGroupExample1">Acceso Total</label>
    </div>

    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" id="defaultGroupExample2" value="no-access" name="special"
            @if($rol->special != null) @if($rol->special == 'no-access') checked @endif @endif>
        <label class="custom-control-label" for="defaultGroupExample2">Ningun Acceso</label>
    </div>
</div>


<div class="form-group {{ $errors->has('permisos') ? 'has-error' : '' }}">
    <label for="permisos">Permisos</label>
    <select name="permisos[]" id="permisos" class="permisos-js form-control" multiple="multiple">
        @foreach($permisos as $id => $permisos)
        <option value="{{ $id }}"
            {{ (in_array($id, old('permisos', []))|| isset($rol) && $rol->permissions->contains($id)) ? 'selected' : '' }}>
            {{ $permisos }}</option>
        @endforeach
    </select>
    @if($errors->has('permisos'))
    <p class="help-block">
        {{ $errors->first('permisos') }}
    </p>
    @endif
</div>

{{--
                @foreach ($permisos as $permiso)
                <div class="custom-control custom-checkbox">
                    <label>
                        <input name="permisos[]" type="checkbox"  >
                        {{$permiso->name}}
</label>
</div>
@endforeach
<div class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" id="defaultChecked2">
    <label class="custom-control-label" for="defaultChecked2">Holis</label>
</div> --}}


@csrf
