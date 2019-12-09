@extends('admin_panel.index')

@section('content')
{{--
<div class="loader"></div> --}}
<div class="content-header">
    <div class="container-fuid">
        <h3>Inicio</h3>
    </div>

</div>

@can('asistencias_create')
@if(auth()->user()->marcoEntrada() === false)
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
                <i class="fal fa-exclamation-triangle"></i>
            </div>
            <a href="{{route('asistencias.index')}}" class="small-box-footer">
                Marcar Entrada
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
@endif
@endcan
<div class="row d-flex justify-content-around">
    <div class="col-md-3">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>
                    {{$cantidadReclamos}}
                </h3>
                <p>
                    Reclamos Registrados
                </p>
            </div>
            <div class="icon">
                <i class="fal fa-clipboard-list"></i>
            </div>
            <a href="{{route('reclamos.index')}}" class="small-box-footer">
                Ver mas
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-cyan">
            <div class="inner">
                <h3>
                    {{$cantidadProveedores}}
                </h3>
                <p>
                    Proveedores Registrados
                </p>
            </div>
            <div class="icon">
                <i class="fal fa-people-carry"></i>
            </div>
            <a href="{{route('proveedores.index')}}" class="small-box-footer">
                Ver mas
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>
                    {{$cantidadEmpleados}}
                </h3>
                <p>
                    Empleados Registrados
                </p>
            </div>
            <div class="icon">
                <i class="fal fa-user"></i>
            </div>
            <a href="{{route('users.index')}}" class="small-box-footer">
                Ver mas
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-navy">
            <div class="inner">
                <h3>
                    {{$cantidadProductos}}
                </h3>
                <p>
                    Productos Registrados
                </p>
            </div>
            <div class="icon">
                <i class="fal fa-cube"></i>
            </div>
            <a href="{{route('productos.index')}}" class="small-box-footer">
                Ver mas
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-fuid">
        @can('trabajos_finalizar')
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">
                                Trabajos Iniciados
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (!$trabajosIniciados->isEmpty())

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
                        @else
                        <div class="justify-content-center">
                            No hay trabajos iniciados!
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endcan
        @can('trabajos_iniciar')
        <div class="row">
            <div class="col-md-12">
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
                                    <th>Duracion Estimada</th>
                                    <th width="20%">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trabajosOrdenados as $trabajo)
                                <tr>
                                    <td>{{$trabajo->reclamo->tipoReclamo->nombre}}</td>
                                    <td>
                                        <p>{{$trabajo->reclamo->direccion->calle}}
                                            {{$trabajo->reclamo->direccion->altura}} ,
                                            {{$trabajo->reclamo->direccion->zona->nombre}}</p>
                                    </td>
                                    <td>
                                        {{$trabajo->reclamo->tipoReclamo->prioridad->nombre}}
                                    </td>
                                    <td style="text-align: start">
                                        {{$trabajo->tiempoDuracionEstimado($trabajo->reclamo->tipoReclamo->id)}} min.
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
                                                                "{{$trabajo->reclamo->direccion->calle}}
                                                                {{$trabajo->reclamo->direccion->altura}},
                                                                {{$trabajo->reclamo->direccion->zona->nombre}}"
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
                                            data-target="#recomendacion{{$trabajo->id}}">Recomendaciones <i
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
                                                                    {{$p->medida->nombre}}
                                                                    (@foreach($trabajo->existenciasAlmacen($p
                                                                    ,$trabajo->recomendacionCantidad($p)) as $almacen)
                                                                    {{$almacen->denominacion}}.
                                                                    @endforeach
                                                                    )
                                                                </li>
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
        </div>
        @endcan
        <br>
        @if(auth()->user()->roles->first()->name == 'EMPLEADO_OFICINA')
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Cantidad de Reclamos en el Tiempo
                    </div>
                    <div class="card-body">
                        <div width="50%">
                            {!! $nivelReclamos->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">
                                Ultimos Reclamos Registrados
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (!$primerosReclamos->isEmpty())

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tipo de Reclamo</th>
                                    <th>Fecha y Hora</th>
                                    <th>Socio</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($primerosReclamos as $pr)
                                <tr>
                                    <td>
                                        {{$pr->tipoReclamo->nombre}}
                                    </td>
                                    <td>
                                        {{$pr->created_at->format('d/m/Y H:i:s')}}
                                    </td>
                                    <td>{{$pr->direccion->socio->apellido}} {{$pr->direccion->socio->nombre}}</td>
                                    <td><a href="{{route('reclamos.show', $pr)}}" class="btn btn-xs btn-adn"><i
                                                class="fas fa-plus"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="justify-content-center">
                            No registro de reclamos!
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {!! $nivelReclamos->script() !!}
        @endif
        @if(auth()->user()->roles->first()->name == 'ENCARGADO_COMPRAS')
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">
                                Pedidos Pendientes
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (!$pedidos->isEmpty())

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Pedido</th>
                                    <th>Fecha</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedidos as $p)
                                <tr>
                                    <td>
                                        {{$p->id}}
                                    </td>
                                    <td>{{$p->getFecha()}}</td>
                                    <td>
                                        <a href="{{route('pedidos.edit' , $p)}}"
                                            class="btn btn-xs btn-secondary">Finalizar
                                            Pedido</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="justify-content-center">
                            No hay pedidos sin finalizar!
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
@push('scripts')
{{-- <script type="text/javascript">
    $(window).load(function() {
        $(".loader").fadeOut("slow");
    });
</script> --}}
@endpush
