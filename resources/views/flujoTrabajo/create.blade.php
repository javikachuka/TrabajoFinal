@extends('admin_panel.index')

@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h2 class="card-title">Nueva Flujo de Trabajo</h2>
                    </div>
                    <div class="card-body">

                        <form class="form-group " method="POST" action="/flujoTrabajos">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="nombre" required value="" class="form-control">
                                <div class="text-danger">{{$errors->first('nombre')}} </div>
                            </div>
                            <div class="text-right">
                                <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>
                                <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm">
                                <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                            </div>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
