@extends('admin_panel.index')

@section('content')

<br>
<form class="form-group " method="POST" action="{{route('trabajos.update' , $trabajo)}}">
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Asignacion de Trabajo</h3>
                </div>
                <div class="card-body">
                    <p>
                        <strong>Detalles del trabajo:</strong> {{$trabajo->reclamo->tipoReclamo->nombre}}
                        <div class="text-inline">
                            <strong> Nivel de Prioridad:</strong>
                            <div class="badge badge-info">{{$trabajo->reclamo->tipoReclamo->prioridad->nombre}} </div>
                        </div>
                        <br>
                        <strong> Ubicacion: </strong> {{$trabajo->reclamo->direccion->calle}} Nº
                        {{$trabajo->reclamo->direccion->altura}},
                        {{$trabajo->reclamo->direccion->zona->nombre}}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Personal Disponible</h3>
                </div>
                <div class="card-body">
                    {{-- <div class="col-md-6">
                        <label for="">Filtro</label>
                        <select class="seleccion form-control" name="user_id" id="filtroEmpleado">
                            <option value="0" selected>Todos</option>
                            <option value="1">De Turno</option>
                        </select>
                    </div>
                    <br> --}}

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Asignado</th>
                                <th>Empleado</th>
                                <th>De Turno</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $empleado)
                            <tr>
                                <td width="75px">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" value="{{$empleado->id}}" class="custom-control-input"
                                            name="empleados[]" id="customCheck{{$empleado->id}}"
                                            @if($empleado->trabajos->contains($trabajo)) checked @endif>
                                        <label class="custom-control-label" for="customCheck{{$empleado->id}}"></label>
                                    </div>
                                </td>
                                <td>
                                    {{$empleado->name}} {{$empleado->apellido}}
                                </td>
                                <td>
                                    @if ($empleado->deTurno())
                                    SI
                                    @else
                                    NO
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>
                        <button type="submit" class=" btn btn-success btn-sm">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @csrf
</form>
@endsection
