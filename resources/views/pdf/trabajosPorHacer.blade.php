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
@section('content')

<div>
    <table id="titulo">
        <thead>
            <tr>
                <th id="fac">Trabajos Por Hacer</th>
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
                    <th>Ubicacion</th>
                    <th>Recomendaciones</th>

                </tr>
            </thead>

            <tbody>

                @foreach ($trabajos as $trabajo)
                <tr>
                    <td>{{$trabajo->id}}</td>
                    <td>{{$trabajo->reclamo->tipoReclamo->nombre}}</td>
                    <td>{{$trabajo->reclamo->socio->direccion->calle}}
                        {{$trabajo->reclamo->socio->direccion->altura}},
                        {{$trabajo->reclamo->socio->direccion->zona->nombre}}
                    </td>
                    <td>
                        <ul>
                            @if(!$trabajo->recomendaciones()->isEmpty())
                            @foreach ($trabajo->recomendaciones() as $p)
                            <li>{{$p->nombre}},
                                {{$trabajo->recomendacionCantidad($p)}}
                                {{$p->medida->nombre}} <br>
                                (@foreach($trabajo->existenciasAlmacen($p ,$trabajo->recomendacionCantidad($p)) as
                                $almacen)
                                {{$almacen->denominacion}}.
                                @endforeach
                                )
                            </li>
                            @endforeach
                            @else
                            <li>No existen sugerencias para este trabajo</li>
                            @endif
                        </ul>
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
