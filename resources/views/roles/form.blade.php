
<div class="container">
        <h2>Datos del Rol</h2>
        <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" value="{{ old('name') ?? $rol->name }}" class="form-control">
                <div>{{$errors->first('name')}} </div>
        </div>
        <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug') ?? $rol->slug }}" class="form-control">
                <div>{{$errors->first('cuit')}} </div>
        </div>
        <div class="form-group">
                <label>Descripcion</label>
                <input type="text" name="description" value="{{ old('description') ?? $rol->description }}"  class="form-control">
                <div>{{$errors->first('description')}} </div>
        </div>

        <div class="form-group">
                <label >Permisos</label>

                @foreach ($permisos as $permiso)
                <div class="custom-control custom-checkbox">
                    <label>
                        <input name="permisos[]" type="checkbox"  >
                        {{$permiso->name}}
                    </label>
                </div>
                @endforeach
                <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultChecked2" >
                        <label class="custom-control-label" for="defaultChecked2">Holis</label>
                </div>
        </div>
    </div>

    @csrf
