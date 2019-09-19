@extends('admin_panel.index')

@section('content')
<div class="content-fluid">
        <div class="row  justify-content-center">
            <div class="col-md-10">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <h3 class="profile-username text-center">Informacion de Movimiento Nº {{$movimiento->id}} </h3>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><i class="fal fa-file-alt mr-1"></i>Datos del Movimiento: <br>
                                    <p>
                                        Tipo de Movimiento: <i class="text-muted"> {{$movimiento->tipoMovimiento->nombre}}</i><br>
                                        Fecha del Movimiento: {{$movimiento->cabeceraMovimiento->fecha}} <br>
                                        Producto: {{$movimiento->producto->nombre}} <br>
                                        @if($movimiento->tipoMovimiento->operacion == true)
                                            Almacen Destino: {{$movimiento->almacenDestino->denominacion}} <br>
                                            Cantidad Ingresada: {{$movimiento->cantidad}} {{$movimiento->producto->medida->nombre}} <br>
                                        @else
                                            Desde el almacen: {{$movimiento->almacenOrigen->denominacion}} <br>
                                            al almacen: {{$movimiento->almacenDestino->denominacion}} <br>
                                            Cantidad Transferida: {{$movimiento->cantidad}} {{$movimiento->producto->medida->nombre}} <br>
                                        @endif

                                    </p>
                                </strong>
                            </div>
                            <div class="col-md-4">
                                    <strong><i class="fal fa-file-alt mr-1"></i>Datos del Comprobante: <br>
                                        <p>
                                            Proveedor <i class="text-muted">{{$movimiento->cabeceraMovimiento->proveedor->nombre}}</i> <br>
                                            Tipo de Comprobante: {{$movimiento->cabeceraMovimiento->tipoComprobante->nombre}} <br>
                                            Numero del Comprobante: {{$movimiento->cabeceraMovimiento->numeroComprobante}} <br>
                                            Fecha del Comprobante: {{$movimiento->cabeceraMovimiento->fechaComprobante}} <br>
                                        </p>
                                    </strong>
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
