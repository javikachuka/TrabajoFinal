@extends('admin_panel.index')

@section('content')
<br>
<div class="content-fluid">
    <div class="row  justify-content-center">
        <div class="col-md-10">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <h3 class="profile-username text-center">Trabajo: {{$trabajo->reclamo->tipoReclamo->nombre}}
                        </h3>
                        <p class="text-muted">Numero de Trabajo: <span class="badge badge-info"><i
                                    class="fal fa-num nav-icon"></i>{{$trabajo->id}}</span></p>
                    </div>
                    <hr>
                    <strong><i class="fal fa-file-alt mr-1"></i>Detalles del Trabajo: </strong>
                    <br>
                    <div class="row">

                        <div class="col-md-5 ">
                            <p>
                                Fecha de creacion: {{$trabajo->getFecha()}}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p>
                                Estado actual: <span class="badge badge-secondary">{{$trabajo->estado->nombre}}</span>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p>
                                {{$trabajo->ultimoEstado()}}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <strong><i class="fal fa-map-marker-alt mr-1"></i>Lugar:</strong>
                        <p class="text-muted"> {{$trabajo->reclamo->direccion->calle}}
                            {{$trabajo->reclamo->direccion->altura}},
                            {{$trabajo->reclamo->direccion->zona->nombre}}
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <strong>Personal Encargado:</strong>
                            @if(!empty($trabajo->users[0]))
                            <ul>
                                @foreach ($trabajo->users as $user)
                                <li>{{$user->name}} {{$user->apellido}}</li>
                                @endforeach
                            </ul>

                            @else
                            <br>
                            <i class="text-muted">No hay registros</i>
                            @endif
                            <div class="form-group my-5">
                                @if (($trabajo->horaFin == null) &&($trabajo->horaInicio == null))
                                <label for="">Tiempo de duracion estimado:
                                    {{$trabajo->tiempoDuracionEstimado($trabajo->reclamo->tipoReclamo->id)}} hs</label>
                                @else
                                <label for="">Tiempo de duracion real: {{$trabajo->tiempoDuracion()}} hs</label>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-5">
                            <strong>Foto del Trabajo</strong><br>
                            @if($trabajo->urlFoto != null)
                            <img src="{{asset('img/trabajos/'.$trabajo->urlFoto)}}" alt="" height="240" width="320">
                            @else
                            <i class="text-muted">No presenta foto debido a que el trabajo aun no ha finalizado</i>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Lista de Productos utilizados
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if($trabajo->cabeceraMovimiento != null)
                                    @foreach ($trabajo->cabeceraMovimiento->movimientos as $movimiento)
                                    <tr>
                                        <td>{{$movimiento->producto->nombre}}</td>
                                        <td>{{$movimiento->cantidad}} {{$movimiento->producto->medida->nombre}}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="2">
                                            <i class="text-muted">Aun no se han utilizado productos en este trabajo</i>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-header d-flex justify-content-center">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
