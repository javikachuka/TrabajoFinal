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
                <th id="fac">Listado de Trabajos Ordenados Por Mayor Duracion</th>
            </tr>
            <tr>
                <th id="filtros">
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
        <table id="lista">
            <thead>
                <tr id="fa">
                    <th>Nr</th>
                    <th>Trabajo</th>
                    <th>Duracion</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($trabajos as $t)
                <tr>
                    <td>{{$t->id}}</td>
                    <td>{{$t->nombre}}</td>
                    <td style="text-align: right">{{$t->DuracionReal}} hs</td>

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
