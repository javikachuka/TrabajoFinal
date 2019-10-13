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
                <th id="fac">Listado de Reclamos</th>
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
                    <th>Tipo</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($reclamos as $rec)
                <tr>
                    <td>{{$rec->id}}</td>
                    <td>{{$rec->tipoReclamo->nombre}}</td>
                    <td>{{$rec->getFecha()}}</td>

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
