@extends('admin_panel.index')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>Asignar Turnos</h3>
        </div>
        <form class="form-group " method="POST" action="{{route("turnos.create")}}" >
            @csrf
        <div class="card-body">
            <div class="row ">
                    <label for="" class="col-12">Empleado</label>
                <div class="col-md-5">

                    <select class="seleccion form-control" name="empleado_id">
                        <option value="" disabled selected>--Seleccione un socio--</option>
                        @foreach($empleados as $empleado)
                            <option value="{{$empleado->id}}">{{$empleado->apellido . ' ' . $empleado->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 offset-3">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary  btn-sm">Configurar Turnos</button>
                    </div>
                </div>
            </div>
        </div>

        </form>

    </div>

@endsection

@push('scripts')
@push('scripts')
<script>
        $(document).ready(function() {
            $('.seleccion').select2();
        });
</script>

@endpush
