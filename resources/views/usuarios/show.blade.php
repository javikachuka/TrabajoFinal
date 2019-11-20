@extends('admin_panel.index')

@section('content')
<br>


<div class="content-fluid">
    <div class="row  justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline">
                <div class="card-header">
                    <h3>Detalles de Empleado</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Apellido y Nombre/s:</strong> {{$user->apellido}} {{$user->name}}
                        </div>
                        <div class="user-panel mt-1 pb-1 mb-1 d-flex">
                            <strong>Foto de Perfil </strong>
                            <div class="image">
                                @if ($user->urlFoto != null)

                                <img src="{{ asset('img/perfiles/'.$user->urlFoto) }}" class="img-circle elevation-2"
                                    alt="User Image">
                                @else
                                <img src="{{ asset('img/perfiles/usuario-sin-foto.png')}}"
                                    class="img-circle elevation-2" alt="User Image">

                                @endif
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>DNI:</strong> {{$user->dni}}
                        </div>
                        <div class="col-md-4">
                            <strong>Fecha de Ingreso:</strong> {{$user->getFecha()}}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Telefono:</strong> {{$user->telefono}}
                        </div>
                        <div class="col-md-4">
                            <strong>Email:</strong> {{$user->email}}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Direccion: </strong> {{$user->direccion->calle}} {{$user->direccion->altura}},
                            {{$user->direccion->zona->nombre}}
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <h4>Turnos asignados</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-fixed" id="turnos">
                                <thead>
                                    <tr>
                                        <th>Dia</th>
                                        <th>Horario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!$user->turnos->isEmpty())
                                    @foreach ($user->turnos as $turno)
                                    <tr>
                                        <td width="35%">
                                            {{$turno->getNombreDia()}}
                                        </td>
                                        <td>
                                            {{$turno->horario->nombre}} ({{$turno->horario->horaEntrada . ' - ' . $turno->horario->horaSalida}} )
                                        </td>
                                    </tr>
                                    @endforeach
                                   @else
                                   <tr>
                                       <td>No hay turnos asignados!</td>
                                   </tr>
                                   @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
