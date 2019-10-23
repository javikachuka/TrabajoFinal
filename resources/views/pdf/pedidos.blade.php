@extends('layouts.pdf2')

@section('logo')
<a><img id="imagen" class="float-left rounded " src="{{public_path('img/').$config->logo}}"> </a>
@endsection

@section('datos')
<p id="encabezado">
    <b>{{$config->nombre}}</b><br>
    {{$config->direccion}}<br>
    Telefono:{{$config->telefono}}<br>
    Email:{{$config->email}}
</p>
@endsection

@section('content')

<div>
    <table id="titulo">
        <thead>
            <tr>
                <th id="fac">Datos del Proveedor</th>
            </tr>
            <tr>
                <td>
                    Proveedor: {{$pedido->proveedor->nombre}}
                </td>
                <td>
                    CUIT: {{$pedido->proveedor->cuit}}

                </td>
            </tr>
            <tr>
                <td>
                    Email: {{$pedido->proveedor->email}}
                </td>
                <td>
                    Telefono: {{$pedido->proveedor->telefono}}
                </td>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <table id="titulo">
        <thead>
            <tr>
                <th id="fac">Detalles del Pedido</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Nº de Pedido: {{$pedido->id}}
                </td>
            </tr>
            <tr>
                <td>
                    Fecha del Pedido: {{$pedido->getFecha()}}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table id="titulo">
        <thead>
            <tr>
                <th id="fac">Lista de Productos Solicitados</th>
            </tr>
        </thead>
    </table>
</div>
<section>
    <div>
        <table id="lista">
            <thead>
                <tr id="fa">
                    <th>Cod. Producto</th>
                    <th style="border-spacing: 15%">Producto</th>
                    <th>Cantidad</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($pedido->detalles as $d)
                <tr>
                    <td>{{$d->producto->codigo}}</td>
                    <td>{{$d->producto->nombre}}</td>
                    <td style="text-align: right">{{$d->cantidad}}</td>
                </tr>
                @endforeach
            </tbody>
            <tbody>
            </tbody>

        </table>
    </div>
</section>
@section('cantidad')
{{$cant}}
@endsection
@stop
