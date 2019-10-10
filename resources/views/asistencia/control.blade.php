@extends('admin_panel.index')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Listado de Asistencia de Empleados</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <label for="">Empleado</label>
                <select class="seleccion form-control " name="empleado_id" id="empleado">
                    <option value="" disabled selected>--Seleccione--</option>
                    @foreach($empleados as $emple)
                    <option value="{{$emple->id}}" {{old('empleado_id') == $emple->id ? 'selected' : ''}}>
                        {{$emple->apellido . ' ' . $emple->name}}</option>
                    @endforeach
                </select>
                <div class="text-danger">{{$errors->first('empleado_id')}} </div>

            </div>
            <div class="col-md-1 d-flex align-items-end ">
                <button class="btn btn-primary btn-sm" id="">Seleccionar</button>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table id="asistencias" class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora de Entrada</th>
                        <th>Hora de Salida</th>
                        <th>Turno</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asistencias as $asistencia)

                    <tr>
                        <td>{{$asistencia->getNombreDia()}} {{$asistencia->getDia()}}</td>
                        <td>{{$asistencia->horaEntrada}}</td>
                        <td>{{$asistencia->horaSalida}}</td>
                        <td>{{$asistencia->empleado->getHorario($asistencia)}}</td>
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
    $(document).ready(function() {
            $('.seleccion').select2();
        });
</script>

<script>
 $(function () {
          $('#asistencias').DataTable({

                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
          });
        });

</script>
@endpush
