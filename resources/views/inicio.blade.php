@extends('admin_panel.index')

@section('content')

<div class="content-header">
    <div class="container-fuid">
        <h3>Inicio</h3>
    </div>

</div>

<div class="content">
    <div class="content-fuid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">
                                Trabajos Pendientes
                            </div>
                            <button class="btn btn-danger btn-xs">Generar</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tipo de Trabajo</th>
                                    <th>Ubicacion</th>
                                    <th>Prioridad</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trabajos as $trabajo)
                                <tr>
                                    <td>{{$trabajo->reclamo->tipoReclamo->nombre}}</td>
                                    <td>
                                        <p>{{$trabajo->reclamo->socio->direccion->calle}}
                                            {{$trabajo->reclamo->socio->direccion->altura}} ,
                                            {{$trabajo->reclamo->socio->direccion->zona->nombre}}</p>
                                    </td>
                                    <td>
                                        {{$trabajo->reclamo->tipoReclamo->prioridad->nombre}}
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#iniciarTrabajo{{$trabajo->id}}">Iniciar <i class="fad fa-play"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
