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
                <th id="fac">Listado de Movimientos</th>
            </tr>
            <tr>
                <th id="filtros">
                    {{$filtro}}
                </th>
            </tr>
        </thead>
        <tbody>
            {{--
            <tr>

                <th><p id="cliente"> Desde: <br>

                Hasta: </p></th>

            </tr> --}}

        </tbody>
    </table>
</div>
</section>
<br>
<section>
    <div>



    </div>
</section>
<br>
<section>
    <div>
        <table id="lista">
            <thead>
                <tr id="fa">
                    <th>Nr</th>
                    <th>Tipo de Movimiento</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha de Movimiento</th>
                    <th>Almacen de Origen</th>
                    <th>Almacen de Destino</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($movimientos as $mov)
                <tr>
                    <td>{{$mov->id}}</td>
                    <td>{{$mov->tipoMovimiento->nombre}}</td>
                    <td>{{$mov->producto->nombre}}</td>
                    <td>{{$mov->cantidad}}</td>
                    <td>{{$mov->cabeceraMovimiento->getFechaMovimiento()}}</td>
                    <td>
                        @if($mov->almacenOrigen != null)
                        {{$mov->almacenOrigen->denominacion}}
                        @else
                        N/A
                        @endif

                    </td>
                    <td>
                        @if($mov->almacenDestino != null)
                        {{$mov->almacenDestino->denominacion}}
                        @else
                        N/A
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody>
            </tbody>

        </table>
    </div>
    @section('cantidad')
    {{$cant}}
    @endsection
    @stop
