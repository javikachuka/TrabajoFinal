@extends('admin_panel.index')

@section('content')

<h2>Edicion de Reclamo</h2>

<div class="card">
    <div class="card-body">
        <form class="form-group " method="POST" action="/reclamos/{{$reclamo->id}}" >
            @method('PUT')
            <label for="">Socio</label>
            <div class="row ">
                <div class="col-sm-4">
                    <label for="">Apellido y Nombre</label>
                    <input type="text" disabled class="form-control" value="{{$reclamo->socio->apellido}} {{$reclamo->socio->nombre}}">
                    {{-- <select class="seleccion form-control" name="socio_id">
                        @foreach($socios as $socio)
                            <option value="{{$socio->id}}" @if ($socio->id == $reclamo->socio->id) selected="selected" @endif>{{$socio->apellido . ' ' . $socio->nombre}}</option>
                        @endforeach
                    </select> --}}
                </div>
                <div class="col-1"></div>
                <div class="col-sm-3">
                    <label for="">DNI</label>
                    <input type="text" disabled class="form-control" value="{{$reclamo->socio->dni}}"> <br>
                </div>
                <div class="col-1">

                </div>
                <div class="col-sm-3">
                    <label for="">Nº de Conexion</label>
                    <input type="text" disabled value="{{$reclamo->socio->nro_conexion}}" class="form-control"> <br>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                        <label for="">Tipo de Reclamo</label>
                        <input type="text" class="form-control" disabled value="{{$reclamo->tipoReclamo->nombre}}">
                </div>
                <div class="col-md-1">

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Fecha del Reclamo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fal fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="date" disabled name="fecha" class="form-control" required value="{{$reclamo->fecha}}" max="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" id="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                    <label for="">Requisitos Presentados</label>
                    <ul id="lista" style="list-style:none">
                        @if(!empty($reclamo->tipoReclamo->requisitos[0]))
                            @foreach ($reclamo->tipoReclamo->requisitos as $requisito)
                            <li> <div class="custom-control custom-checkbox">
                                    <input type="checkbox" value="{{$requisito->id}}" class="custom-control-input" name="requisitos[]" id="customCheck{{$requisito->id}}" @if($reclamo->presentoRequisito($requisito)) checked @endif>
                                    <label class="custom-control-label" for="customCheck{{$requisito->id}}">{{$requisito->nombre}}</label>
                                </div>
                            </li>
                            @endforeach
                        @else
                            <li><i class="text-muted">El tipo de reclamo no presenta requisitos necesarios.</i></li>
                        @endif
                    </ul>
             </div>
            <div class="form-group">
            <label for="">Detalles</label>
            <textarea name="detalle" class="form-control" id="" cols="10" rows="3">{{$reclamo->detalle}}</textarea>
            </div>
            <div class="text-right">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>
                    <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm">
                    <button type="submit" class="btn btn-success btn-sm">Modificar</button>
            </div>
            @csrf
        </form>
    </div>
</div>

@endsection

@push('scripts')

@endpush
