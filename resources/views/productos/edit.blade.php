@extends('admin_panel.index')

@section('content')

<form class="form-group " method="POST" action="/productos/{{$producto->id}}" >
    @method('PATCH')
    @include('productos.form')
    <div class="text-right">
            <input type="reset" value="Limpiar" class="btn btn-secondary">
            <button type="submit" class="btn btn-success">Modificar</button>
    </div>
</form>

@endsection

