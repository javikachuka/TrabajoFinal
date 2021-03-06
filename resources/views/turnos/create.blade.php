@extends('admin_panel.index')

@section('content')
<form class="form-group " method="POST" action="{{route('turnos.store')}}">

    <div class="card">
        <div class="card-header">
            <h3>Asignar Turnos</h3>
        </div>
        <div class="card-body">
            <div class="row ">
                <label for="" class="col-12">Empleado</label>
                <div class="col-md-5">

                    <select class="seleccion form-control" name="empleado_id" id="empleado">
                        <option value="" disabled selected>--Seleccione un empleado--</option>
                        @foreach($empleados as $emple)
                        <option value="{{$emple->id}}" {{old('empleado_id') == $emple->id ? 'selected' : ''}}>
                            {{$emple->apellido . ' ' . $emple->name}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">{{$errors->first('empleado_id')}} </div>
                </div>

            </div>

        </div>
    </div>

    {{-- <input type="hidden" name="empleado_id" value="{{$empleado->id}}"> --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4>Dias de la semana</h4>
                </div>
                <div class="card-body">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="1" name="dias[]" id="lunes">
                        <label class="custom-control-label" for="lunes">Lunes</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="2" name="dias[]" id="martes">
                        <label class="custom-control-label" for="martes">Martes</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="3" name="dias[]" id="miercoles">
                        <label class="custom-control-label" for="miercoles">Miercoles</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="4" name="dias[]" id="jueves">
                        <label class="custom-control-label" for="jueves">Jueves</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="5" name="dias[]" id="viernes">
                        <label class="custom-control-label" for="viernes">Viernes</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="6" name="dias[]" id="sabado">
                        <label class="custom-control-label" for="sabado">Sabado</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="0" name="dias[]" id="domingo">
                        <label class="custom-control-label" for="domingo">Domingo</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Horarios Disponibles</h4>
                </div>
                <div class="card-body">
                    <table class="table table-fixed">
                        <thead>
                            <tr>
                                <th>Turno</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($horarios as $horario)
                            <tr>
                                <td>{{$horario->nombre}}</td>
                                <td>{{$horario->horaEntrada}}</td>
                                <td>{{$horario->horaSalida}}</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="horarios[]"
                                            value="{{$horario->id}}" id="c{{$horario->id}}">
                                        <label class="custom-control-label" for="c{{$horario->id}}"></label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button id="botonTurno" class="addRow btn btn-block btn-primary btn-sm">Asignar Turno</button>
                </div>
            </div>
        </div>
        <div class="col-md-5">
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @csrf
</form>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
            $('.seleccion').select2();
        });
</script>

<script>
    $(document).ready(function(){
        var emple_id = $('#empleado').val();
        if(emple_id != null){
            $('#turnos tbody').children().remove();
            // alert(tip_rec_id) ;
            //AJAX
            // console.log(emple_id);

            $.get('/api/turnos/asignacion/'+emple_id+'', function(data){
                // $('#lista').html(html_select) ;

                if(data['turnos'].length>0){

                    for(var i = 0 ; i<data['turnos'].length ; i++){
                        switch (data['turnos'][i].dia) {
                        case 1:
                            day = "Lunes";
                            break;
                        case 2:
                            day = "Martes";
                            break;
                        case 3:
                            day = "Miercoles";
                            break;
                        case 4:
                            day = "Jueves";
                            break;
                        case 5:
                            day = "Viernes";
                            break;
                        case 6:
                            day = "Sabado";
                            break;
                        case 0:
                            day = "Domingo";
                    }

                        for (var j = 0; j < data['horarios'].length; j++) {

                            if(data['turnos'][i].horario_id == data['horarios'][j].id){
                                var fila =  '<tr>'+

                                            '<td>'+day+'</td>' +
                                            '<td>'+data['horarios'][j].horaEntrada+' - '+data['horarios'][j].horaSalida+'</td>'+
                                            '<td>'+
                                            '<form method="POST" action="/turnos/'+data['turnos'][i].id+'/'+emple_id+'" onsubmit="return confirm()" style="display: inline-block;">'+
                                            '@csrf'+
                                            ' @method('DELETE')'+
                                                '<input value="Borrar" type="submit" class="btn btn-sm btn-danger btn-xs btn-delete">'+
                                            '</form>'+
                                            '</td>'+
                                        '</tr>' ;

                                $('#turnos tbody').append(fila);

                            }

                        }

                }

            } else {

            }
        });
        }


        $('#empleado').change(function(){
            var emple_id = $('#empleado').val();
            var url = "{{ route('turnos.obtener', ":id") }}" ;
            url = url.replace(':id' , emple_id) ;

            $('#turnos tbody').children().remove();
            // alert(tip_rec_id) ;
            //AJAX
            // console.log(emple_id);
            $.get(url , function(data){
                // $('#lista').html(html_select) ;

                if(data['turnos'].length>0){

                    for(var i = 0 ; i<data['turnos'].length ; i++){
                        switch (data['turnos'][i].dia) {
                        case 1:
                            day = "Lunes";
                            break;
                        case 2:
                            day = "Martes";
                            break;
                        case 3:
                            day = "Miercoles";
                            break;
                        case 4:
                            day = "Jueves";
                            break;
                        case 5:
                            day = "Viernes";
                            break;
                        case 6:
                            day = "Sabado";
                            break;
                        case 0:
                            day = "Domingo";
                    }

                    for (var j = 0; j < data['horarios'].length; j++) {

                        if(data['turnos'][i].horario_id == data['horarios'][j].id){

                            var fila =  '<tr>'+
                                        '<td>'+day+'</td>' +
                                        '<td>'+data['horarios'][j].horaEntrada+' - '+data['horarios'][j].horaSalida+'</td>'+
                                        '<td>'+
                                        '<form method="POST" action="/turnos/'+data['turnos'][i].id+'/'+emple_id+'" onsubmit="return confirm()" style="display: inline-block;">'+
                                        '@csrf'+
                                        ' @method('DELETE')'+
                                            '<input value="Borrar" type="submit" class="btn btn-sm btn-danger btn-xs btn-delete">'+
                                        '</form>'+
                                        '</td>'+
                                    '</tr>' ;

                            $('#turnos tbody').append(fila);
                        }
                    }
                }

            } else {

            }
        });
    });



    });

</script>

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
