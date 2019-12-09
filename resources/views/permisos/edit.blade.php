@extends('admin_panel.index')

@section('content')
<br>
<form class="form-group " method="POST" action="/permisos/{{$permiso->id}}">
    @method('PUT')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card ">
                    <div class="card-header">
                        <h3>Nuevo Permiso</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="name" required value="{{ old('name') ?? $permiso->name }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" required value="{{ old('slug') ?? $permiso->slug }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Descripcion</label>
                            <input type="text" name="description" required
                                value="{{ old('description') ?? $permiso->description }}" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>
                            <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @csrf
</form>

@endsection
