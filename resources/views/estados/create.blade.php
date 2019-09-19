@extends('admin_panel.index')


@section('content')
<form class="form-group " method="POST" action="/estados" >
    <section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h2 class="card-title">Nuevo Estado</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" required value=""  class="form-control">
                        </div>
                        <div class="text-right">
                                <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm">
                                <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                            </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    @csrf

</form>
@endsection
