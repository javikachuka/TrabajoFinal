@extends('admin_panel.index')

@section('content')
<div class="content-fluid">
        <div class="row  justify-content-center">
            <div class="col-md-10">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <h3 class="profile-username text-center">Reclamo: {{$reclamo->tipoReclamo->nombre}} </h3>
                            <p class="text-muted">Numero de Reclamo: <span class="badge badge-info"><i class="fal fa-num nav-icon"></i>{{$reclamo->id}}</span></p>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><i class="fal fa-file-alt mr-1"></i>Realizado por: <br>
                                    <p>
                                        Nombre: <i class="text-muted"> {{$reclamo->direccion->socio->apellido}} {{$reclamo->direccion->socio->nombre}} </i><br>
                                        Dni: {{$reclamo->direccion->socio->dni}} <br>
                                        Numero de Conexion: {{$reclamo->direccion->nro_conexion}} <br>
                                        El dia: {{$reclamo->fecha}} <br>
                                        Detalles: {{$reclamo->detalle}}
                                    </p>
                                </strong>
                            </div>
                            <div class="col-md-4">
                                    <strong><i class="fal fa-file-alt mr-1"></i>Registrado por: <br>
                                        <p>
                                            Nombre: <i class="text-muted"> {{$reclamo->usuario->apellido}} {{$reclamo->usuario->name}} </i><br>
                                            Rol: {{$reclamo->usuario->roles[0]->name}}
                                        </p>
                                    </strong>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fal fa-map-marker-alt mr-1"></i>Lugar del Incidente</strong>
                                <p class="text-muted">{{$reclamo->direccion->calle}}  {{$reclamo->direccion->altura}},
                                    {{$reclamo->direccion->zona->nombre}}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="card">
                            <div class="card-header">
                                Historial de Estados
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Estado</th>
                                            <th>Fecha y Hora</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($reclamo->historial as $h)
                                        <tr>
                                                <td>{{$h->id}}</td>
                                                <td>{{$h->estado->nombre}}</td>
                                                <td>{{$h->getFechaHora()}}</td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
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
