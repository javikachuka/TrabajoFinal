@extends('admin_panel.index')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Seleccion de Empleado</h3>
    </div>
    <form class="form-group" method="GET" action="{{route('asistencias.obtenerAsistencias')}}">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <label for="">Empleado</label>
                    <select class="seleccion form-control " name="empleado_id" id="empleado" required>
                        <option value="" disabled selected>--Seleccione--</option>
                        @foreach($empleados as $emple)
                        <option value="{{$emple->id}}" {{old('empleado_id') == $emple->id ? 'selected' : ''}}>
                            {{$emple->apellido . ' ' . $emple->name}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">{{$errors->first('empleado_id')}} </div>

                </div>
                <div class="col-md-1 d-flex align-items-end ">
                    <button type="submit" class="btn btn-primary btn-sm">Seleccionar</button>
                    {{-- <a class="btn btn-primary btn-sm" onclick="{{route('asistencias.obtenerAsistencias')}}"
                    id="seleccionar">Seleccionar</a> --}}
                </div>

            </div>
        </div>

        @csrf
    </form>
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

{{-- <script>
    $('#seleccionar').on('click',function(){
        cargarAsistencias();
    });

    function cargarAsistencias(){
        var t = $('#asistencias') ;


    }



</script> --}}
{{-- <script>
    $('#seleccionar').on('click',function(){
        cargarAsistencias();
    });

    function cargarAsistencias(){
        var t = $('#asistencias').DataTable() ;
        var emple_id = $('#empleado').val();
        var url = "{{ route('asistencias.obtener', ":id") }}" ;
url = url.replace(':id' , emple_id) ;
t.rows().remove().draw();
$.get(url , function(data){
if(data['asistencias'].length>0){
for (var i = 0; i < data['asistencias'].length; i++) { t.row.add( [ data['fechas'][i] ,
    data['asistencias'][i].horaEntrada , data['asistencias'][i].horaSalida, ] ).draw(false) ; }; }; }); } </script> --}}
    @endpush
