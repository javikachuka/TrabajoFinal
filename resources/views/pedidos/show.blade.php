@extends('admin_panel.index')

@section('content')
<div class="content-fluid">
    <div class="row  justify-content-center">
        <div class="col-md-10">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <h3 class="profile-username text-left">Pedido Nº: {{$pedido->id}} </h3>
                    </div>
                    <br>
                    <div class="row justify-content-around">
                        <div class="col-md-6">
                            <strong><i class="fal fa-file-alt mr-1"></i>Datos del Proveedor:  </strong><br>
                                <p>
                                    @if($pedido->proveedor != null)
                                    Proveedor: <i class="text-muted"> {{$pedido->proveedor->nombre}}</i><br>
                                    CUIT: {{$pedido->proveedor->cuit}} <br>
                                    Email: {{$pedido->proveedor->email}} <br>
                                    Telefono: {{$pedido->proveedor->telefono}} <br>
                                    @else
                                        <i class="text-muted">Sin Asignar</i>
                                    @endif
                                </p>

                        </div>
                        <div class="col-md-6">
                            <strong><i class="fal fa-file-alt mr-1"></i>Datos de la Empresa: </strong> <br>
                                <p>
                                    Nombre: <i class="text-muted"> {{$config->nombre}}</i><br>
                                    Direccion: {{$config->direccion}} <br>
                                    Email: {{$config->email}} <br>
                                    Telefono: {{$config->telefono}} <br>
                                </p>

                        </div>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="card-header">
                            Lista de Productos Pedidos
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
                                    @foreach ($pedido->detalles as $d)
                                    <tr>
                                        <td>{{$d->producto->nombre}}</td>
                                        <td>{{$d->cantidad}}</td>
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
