@extends('layouts.pdf2')
@section('content')

<div>
    <table id="titulo">
        <thead>
            <tr>
                <th id="fac">Listado de Movimientos</th>
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
            <th>Fecha</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Almacen de Origen</th>
            <th>Almacen de Destino</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($movimientos as $mov)
            <tr>
                <td>{{$mov->id}}</td>
                <td>{{$mov->tipoMovimiento->nombre}}</td>
                <td>{{$mov->cabeceraMovimiento->fecha}}</td>
                <td>{{$mov->producto->nombre}}</td>
                <td>{{$mov->cantidad}}</td>
                <td>nada</td>
                <td>{{$mov->almacenDestino->denominacion}}</td>
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
