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
                <th id="fac">Listado de Asistencias</th>
            </tr>
            <tr>
                <th id="filtros">
                    Empleado: {{$empleado->apellido}} {{$empleado->name}} <br>
                    DNI: {{$empleado->dni}} <br>
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
                    <th>Dia</th>
                    <th>Fecha</th>
                    <th>Hora Entrada</th>
                    <th>Hora Salida</th>
                    <th>Horario</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($asistencias as $asistencia)
                <tr>
                    <td>{{$asistencia->getNombreDia()}}</td>
                    <td>{{$asistencia->getDia()}}</td>
                    <td>{{$asistencia->horaEntrada}}</td>
                    <td>{{$asistencia->horaSalida}}</td>
                    <td>{{$asistencia->empleado->getHorario($asistencia)}}</td>

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
