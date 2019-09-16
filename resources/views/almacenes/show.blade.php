@extends('admin_panel.index')

@section('content')
<div class="content-fluid">
    <H2>Datos del Almacen</H2>
        <div class="row  justify-content-center">
            <div class="col-md-10">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <h3 class="profile-username text-center">Almacen: {{$almacen->denominacion}} </h3>
                            {{-- <p class="text-muted">Cantidad de productos: <span class="badge badge-info"><i class="fal fa-num nav-icon"></i>{{$almacen->}}</span></p> --}}

                        </div>
                        <hr>
                        <strong><i class="fal fa-map-marker-alt mr-1"></i>Ubicacion</strong>
                        <p class="text-muted">{{$almacen->direccion->calle}}  {{$almacen->direccion->altura}}  <br>
                            {{$almacen->direccion->zona->nombre}}
                        </p>
                        <hr>
                        <div class="card">
                            <div class="card-header">
                                Listado de Productos
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Rubro</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    @foreach ($almacen->existencias as $exis)
                                        <tr>
                                                <td>{{$exis->id}}</td>
                                                <td>{{$exis->producto->nombre}}</td>
                                                <td>{{$exis->producto->rubro->nombre}}</td>
                                                <td>{{$exis->cantidad}}</td>
                                            </tr>
                                    @endforeach

                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
