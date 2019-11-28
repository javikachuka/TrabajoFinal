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
                    @if($movimiento->tipoMovimiento->operacion != false)
                    <strong><i class="fal fa-file-alt mr-1"></i>Datos del Comprobante </strong>
                    <br>
                    @endif
                    <div class="row">
                        @if ($movimiento->tipoMovimiento->operacion == true)
                        <div class="col-md-4">
                            <p>
                                Proveedor: <i
                                    class="text-muted">{{$movimiento->cabeceraMovimiento->proveedor->nombre}}</i> <br>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p>
                                Cuit: {{$movimiento->cabeceraMovimiento->proveedor->cuit}}
                            </p>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        @if($movimiento->tipoMovimiento->operacion != false)
                        <div class="col-md-4">
                            <p>Tipo de Comprobante: {{$movimiento->cabeceraMovimiento->tipoComprobante->nombre}}</p>
                        </div>
                        <div class="col-md-4">
                            <p> Nº del Comprobante: {{$movimiento->cabeceraMovimiento->numeroComprobante}} </p>
                        </div>

                        <div class="col-md-4">
                            <p>Fecha del Comprobante: {{$movimiento->cabeceraMovimiento->getFechaComprobante()}} </p>
                        </div>
                        @endif
                    </div>
                    <hr>
                    <strong><i class="fal fa-file-alt mr-1"></i>Datos del Movimiento: </strong>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <p>
                                Tipo de Movimiento: <i class="text-muted">
                                    {{$movimiento->tipoMovimiento->nombre}}</i><br>
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
                        @elseif($movimiento->tipoMovimiento->operacion != false)
                        <div class="col-md-4">
                            <p>
                                Desde el almacen: {{$movimiento->almacenOrigen->denominacion}} <br>
                                al almacen: {{$movimiento->almacenDestino->denominacion}} <br>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p>
                                Cantidad Transferida: {{$movimiento->cantidad}}
                                {{$movimiento->producto->medida->nombre}} <br>
                            </p>
                        </div>

                        @else
                        <div class="col-md-4">
                            <p>
                                Cantidad Utilizada: {{$movimiento->cantidad}} {{$movimiento->producto->medida->nombre}}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p>
                                Almacen Origen: {{$movimiento->almacenOrigen->denominacion}} <br>
                            </p>
                        </div>
                        <div class="col-md-4">

                        </div>

                        <div class="col-md-4">
                            <p>
                                Nº de Trabajo: {{$movimiento->cabeceraMovimiento->trabajo->id}}
                                <br>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p>
                                Trabajo: {{$movimiento->cabeceraMovimiento->trabajo->reclamo->tipoReclamo->nombre}}
                                <br>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p>
                                Fecha de Creacion: {{$movimiento->cabeceraMovimiento->trabajo->getFecha()}} <br>
                            </p>
                        </div>
                        @endif
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
