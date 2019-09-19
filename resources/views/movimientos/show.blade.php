@extends('admin_panel.index')

@section('content')
<br>
<div class="content-fluid">
        <div class="row  justify-content-center">
            <div class="col-md-10">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <h3 class="profile-username text-center">Informacion de Movimiento Nº {{$movimiento->id}} </h3>
                        </div>
                        <strong><i class="fal fa-file-alt mr-1"></i>Datos del Comprobante </strong>
                        <br>
                        <div class="row">
                                <div class="col-md-4">
                                    <p>
                                    Proveedor: <i class="text-muted">{{$movimiento->cabeceraMovimiento->proveedor->nombre}}</i> <br>
                                    </p>
                                </div>
                                <div class="col-md-2">
                                    <p>
                                        Cuit: {{$movimiento->cabeceraMovimiento->proveedor->cuit}}
                                    </p>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-4">
                                    <p>Tipo de Comprobante: {{$movimiento->cabeceraMovimiento->tipoComprobante->nombre}}</p>
                                </div>
                                <div class="col-md-4">
                                   <p> Nº del Comprobante: {{$movimiento->cabeceraMovimiento->numeroComprobante}} </p>
                                </div>

                                <div class="col-md-4">
                                    <p>Fecha del Comprobante: {{$movimiento->cabeceraMovimiento->getFechaComprobante()}} </p>
                                </div>
                        </div>
                        <hr>
                        <strong><i class="fal fa-file-alt mr-1"></i>Datos del Movimiento:  </strong>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                    <p>
                                        Tipo de Movimiento: <i class="text-muted"> {{$movimiento->tipoMovimiento->nombre}}</i><br>
                                    </p>
                            </div>
                            <div class="col-md-4">
                                <p>
                                    Producto: {{$movimiento->producto->nombre}} <br>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p>
                                    Fecha del Movimiento: {{$movimiento->cabeceraMovimiento->getFechaMovimiento()}}
                                </p>
                            </div>
                            @if($movimiento->tipoMovimiento->operacion == true)
                                <div class="col-md-4">
                                    <p>
                                        Cantidad Ingresada: {{$movimiento->cantidad}} {{$movimiento->producto->medida->nombre}}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p>
                                        Almacen Destino: {{$movimiento->almacenDestino->denominacion}}
                                    </p>
                                </div>
                            @else
                                <div class="col-md-4">
                                    <p>
                                        Desde el almacen: {{$movimiento->almacenOrigen->denominacion}} <br>
                                        al almacen: {{$movimiento->almacenDestino->denominacion}} <br>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p>
                                        Cantidad Transferida: {{$movimiento->cantidad}} {{$movimiento->producto->medida->nombre}} <br>
                                    </p>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>

                        <hr>
                        {{-- <strong><i class="fal fa-map-marker-alt mr-1"></i>Lugar del Incidente</strong>
                        <p class="text-muted">{{$reclamo->socio->direccion->calle}}  {{$reclamo->socio->direccion->altura}}  <br>
                            {{$reclamo->socio->direccion->zona->nombre}}
                        </p> --}}
                        {{-- <hr>
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
                                        <tr>
                                            @foreach ($reclamo->historial as $h)
                                                <td>{{$h->id}}</td>
                                                <td>{{$h->estado->nombre}}</td>
                                                <td>{{$h->created_at}}</td>
                                            @endforeach
                                        </tr>

                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                        </div> --}}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
