@extends('admin_panel.index')

@section('content')
<br>

<div class="content-fluid">
    <div class="row  justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header box-profile">
                    <div class="text-center">
                        <h3 class="profile-username text-center">{{$producto->nombre}} </h3>
                        <p class="text-muted">Rubro: <span class="badge badge-info"><i
                                    class="fal fa-tags nav-icon"></i>{{$producto->rubro->nombre}}</span></p>
                        <p class="text-muted">Codigo: {{$producto->codigo}}</p>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($exis as $e)
                        <div class="col-md-4">
                            <div class="card card-primary">
                                <div class="card-header">
                                    {{$e->almacen->denominacion}}
                                </div>
                                <div class="card-body">

                                    <strong><i class="fal fa-file-alt mr-1"></i>Cantidad Disponible: <i
                                            class="text-muted">{{$e->cantidad}}
                                            {{$e->producto->medida->nombre}}</i></strong>
                                    <hr>
                                    <strong><i class="fal fa-map-marker-alt mr-1"></i>Ubicacion</strong>
                                    <p class="text-muted">{{$e->almacen->direccion->calle}}
                                        {{$e->almacen->direccion->altura}} <br></p>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-center">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>

                </div>
            </div>
        </div>
    </div>
</div>



@endsection
