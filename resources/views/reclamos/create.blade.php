@extends('admin_panel.index')

@section('content')

    <h2>Carga de Nuevo Reclamo</h2>

    <div class="card">
    <div class="card-body">
      <form class="form-group " method="POST" action="/reclamos" >
        <div class="row">
                    <div class="col-sm-3">
                        <label for="">Socio</label>
                        <select class="seleccion form-control" name="socio_id">
                            @foreach($socios as $socio)
                                <option value="{{$socio->id}}">{{$socio->apellido . ' ' . $socio->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                            <label for="">Tipo de Reclamo</label>
                            <select class="seleccion form-control" name="tipoReclamo_id">
                                @foreach($tipos_reclamos as $tipo_reclamo)
                                    <option value="{{$tipo_reclamo->id}}">{{$tipo_reclamo->nombre}}</option>
                                @endforeach
                            </select>
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
                                <input type="date" name="fecha" class="form-control" required value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" id="">
                            </div>
                        </div>
                    </div>

        </div>

        <div class="form-group">
            <label for="">Detalles</label>
            <textarea name="detalle" class="form-control" id="" cols="10" rows="3"></textarea>
        </div>
        <div class="text-left">
                <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm">
                <button type="submit" class="btn btn-success btn-sm">Generar Reclamo</button>
        </div>
        @csrf
      </form>
    </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.seleccion').select2();
    });
</script>

@endpush
