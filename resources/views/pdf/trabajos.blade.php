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
                    <th>Tipo de Trabajo</th>
                    <th>Fecha</th>
                    <th>Ubicacion</th>
                    <th>Empleado/s</th>
                    <th>Prioridad</th>
                    <th>Estado Actual</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($trabajos as $t)
                <tr>
                    <td>{{$t->id}}</td>
                    <td>{{$t->reclamo->tipoReclamo->nombre}}</td>
                    <td>{{$t->getFecha()}}</td>
                    <td>
                        <p>{{$t->reclamo->direccion->calle}}
                            {{$t->reclamo->direccion->altura}} ,
                            {{$t->reclamo->direccion->zona->nombre}}</p>
                    </td>
                    <td>
                        @if (!$t->users->isEmpty())
                            @foreach ($t->users as $emple)
                            {{$emple->name}} {{$emple->apellido}}
                            @endforeach
                        @else
                        Sin Asignar
                        @endif
                    </td>
                    <td>{{$t->reclamo->tipoReclamo->prioridad->nombre}}</td>
                    <td>{{$t->estado->nombre}}</td>

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
