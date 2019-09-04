@extends('layouts.app')

@section('content')

<form class="form-group " method="POST" action="/roles/{{$rol->id}}" >
    @method('PUT')
    @include('roles.form')
    <div class="text-right">
            <input type="reset" value="Limpiar" class="btn btn-secondary">
            <button type="submit" class="btn btn-success">Modificar</button>
    </div>
</form>

@endsection

