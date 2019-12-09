@extends('admin_panel.index')

@section('content')
<h1>Transiciones</h1>
@if (session()->has('message'))
<div class="alert alert-danger">
    Error {{session('message')}}
</div>
@endif
<br>



<form class="form-group " method="POST" action="/transiciones/{{$flujoTrabajo->id}}">
    <div class="row">

        <div class="col-md-4">
            <div class="info-box mb-3 bg-info">
                <span class="info-box-icon">
                    <i class="fal fa-project-diagram"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Flujo de Trabajo</span>

                    <span class="info-box-text">{{$flujoTrabajo->nombre}}</span>

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-info card-outline">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nombre de la Transicion</label>
                        <input type="text" name="nombre" id="nombre" required class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Estado Inicial</label>
                            <div class="form-group">
                                <select name="estadoInicial_id" id="estadoInicial_id" class="form-control" required>
                                    @foreach ($estados as $estado)
                                    <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Estado Final</label>
                            <div class="form-group">
                                <select name="estadoFinal_id" id="estadoFinal_id" class="form-control" required>
                                    @foreach ($estados as $estado)
                                    <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>
                        <button type="submit" class="btn btn-success btn-sm">Asignar Transicion</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
    @csrf
</form>
<hr>


<h4 class="font-weight-light">Lista de Transiciones Asignadas</h2>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="users" class="table table-sm table-bordered table-striped table-hover datatable">
                    <thead>
                        <tr>
                            <th scope="col">Transicion</th>
                            <th scope="col">Estado Inicial</th>
                            <th scope="col">Estado Final</th>
                            <th scope="col">Posicion</th>
                            <th scope="col">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($flujoTrabajo->transiciones as $tran)
                        <tr>
                            <td>{{$tran->nombre}}</td>
                            <td>{{$tran->estadoInicial->nombre}}</td>
                            <td>{{$tran->estadoFinal->nombre}}</td>
                            <td>
                                <a href="#" class="up"><i class="fas fa-caret-up"></i></a> <a href="#" class="down"><i
                                        class="fas fa-caret-down"></i></a></td>
                            <td width="75px">
                                <form method="POST" action="{{route('transiciones.destroy', $tran->id)}}"
                                    onsubmit="return confirm('Desea borrar a {{$tran->nombre}}')"
                                    style="display: inline-block;">
                                    @method('DELETE')
                                    @csrf
                                    @can('transiciones_destroy')
                                    <button type="submit" class="btn btn-sm btn-danger btn-xs btn-delete"><i
                                            class="fas fa-minus"></i></button>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @endsection

    @push('scripts')
    <script>
        @if(session('confirmar'))
            Confirmar.fire() ;
        @elseif(session('cancelar'))
            Cancelar.fire();
        @elseif(session('borrado'))
            Borrado.fire();
        @endif
    </script>
    @endpush
