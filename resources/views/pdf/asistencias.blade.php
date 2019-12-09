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
                    <th>Horario</th>
                    <th>Hora Entrada</th>
                    <th>Hora Salida</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($asistencias as $asistencia)
                <tr>
                    <td>{{$asistencia->getNombreDia()}}</td>
                    <td>{{$asistencia->getDia()}}</td>
                    <td width="30%">
                        {{$asistencia->empleado->getHorario($asistencia)->nombre }} <br> {{ $asistencia->empleado->getHorario($asistencia)->horaEntrada .' - '. $asistencia->empleado->getHorario($asistencia)->horaSalida }}
                    </td>
                    <td>
                        @if($asistencia->horaEntrada != null)
                        {{$asistencia->horaEntrada}}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if ($asistencia->horaSalida)
                        {{$asistencia->horaSalida}}
                        @else
                        -
                        @endif
                    </td>
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
