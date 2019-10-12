@extends('admin_panel.index')

@section('content')

<div class="content-header">
    <div class="container-fuid">
        <h3>Inicio</h3>
    </div>

</div>

<div class="row d-flex justify-content-center">
    <div class="col-md-8 ">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>
                    Atencion
                </h3>
                <p>
                    Aun no has registrado tu entrada!
                </p>
            </div>
            <div class="icon">
                <i class="fal fa-exclamation-triangle" ></i>
            </div>
            <a href="{{route('asistencias.index')}}" class="small-box-footer">
                Marcar Entrada
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="content">
    <div class="content-fuid">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">
                                Trabajos Pendientes
                            </div>
                            <a href="{{route('trabajosPorHacer.pdf')}}" class="btn btn-danger btn-xs">Generar <i
                                    class="fa fa-file-pdf"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (!$trabajosOrdenados->isEmpty())
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tipo de Trabajo</th>
                                        <th>Ubicacion</th>
                                        <th>Prioridad</th>
                                        <th width="17%">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trabajosOrdenados as $trabajo)
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
                                            <button class="btn btn-xs btn-success" data-toggle="modal"
                                                data-target="#iniciarTrabajo{{$trabajo->id}}">Iniciar <i
                                                    class="fad fa-play"></i></button>
                                            <!-- Modal Inicio -->
                                            <div class="modal fade" id="iniciarTrabajo{{$trabajo->id}}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Inicio de Trabajo
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form class="form-group " method="GET"
                                                            action="{{route('trabajos.iniciarTrabajo', $trabajo)}}">

                                                            <div class="modal-body">
                                                                <strong><i
                                                                        class="fal fa-exclamation-circle mr-1"></i>Atencion</strong>
                                                                <p>Debe encontrarse en la direccion
                                                                    "{{$trabajo->reclamo->socio->direccion->calle}}
                                                                    {{$trabajo->reclamo->socio->direccion->altura}},
                                                                    {{$trabajo->reclamo->socio->direccion->zona->nombre}}"
                                                                    para comenzar el trabajo!
                                                                </p>

                                                                <i class="text-muted">Si se encuentra en la direccion oprima
                                                                    CONTINUAR</i>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-dismiss="modal">Cerrar</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary btn-sm ">Continuar</button>
                                                            </div>
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="btn btn-xs btn-warning" data-toggle="modal"
                                                data-target="#recomendacion{{$trabajo->id}}"> <i
                                                    class="fas fa-exclamation-square"></i></a>
                                            <!-- Modal Recomendacion -->
                                            <div class="modal fade" id="recomendacion{{$trabajo->id}}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Recomendaciones
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <ul>
                                                                    @if(!$trabajo->recomendaciones()->isEmpty())
                                                                    @foreach ($trabajo->recomendaciones() as $p)
                                                                    <li>{{$p->nombre}},
                                                                        {{$trabajo->recomendacionCantidad($p)}}
                                                                        {{$p->medida->nombre}}</li>
                                                                    @endforeach
                                                                    @else
                                                                    <li>No existen sugerencias para este trabajo</li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                data-dismiss="modal">Cerrar</button>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                        <div class="justify-content-center">
                            No hay trabajos pendientes!
                        </div>

                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">
                                Trabajos Iniciados
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tipo de Trabajo</th>
                                    <th>Tiempo</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trabajosIniciados as $trabIni)
                                <tr>
                                    <td>
                                        {{$trabIni->reclamo->tipoReclamo->nombre}}
                                    </td>
                                    <td>{{$trabIni->diferencia()}}</td>
                                    <td>
                                        <button class="btn btn-xs btn-danger"
                                            onclick="location.href='{{route('trabajos.finalizarTrabajo', $trabIni)}}'">Finalizar
                                            <i class="fad fa-window-close"></i></button>
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
