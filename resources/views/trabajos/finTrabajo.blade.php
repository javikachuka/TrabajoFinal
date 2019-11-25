@extends('admin_panel.index')


@section('content')

<form class="form-group " method="POST" action="{{route('trabajos.guardarFinalizacion', $trabajo)}}"
    enctype="multipart/form-data">
    @method('PUT')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Finalizar Trabajo
            </div>
        </div>
        <div class="card-body">
            <div class="row justify-content-start">
                <div class="col-md-4">
                    <p><strong>Trabajo: </strong> {{$trabajo->reclamo->tipoReclamo->nombre}}</p> <br>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <p><strong>Fecha y Hora de finalizacion: </strong> <input type="datetime" id="fechaMod"
                            class="form-control" disabled value="{{ Carbon\Carbon::now()->format('d/m/Y H:i') }}">

                    </p>
                    <input type="hidden" name="fechaFin" id="fechaFinalizacion" value="{{ Carbon\Carbon::now()->format('Y-m-d H:i') }}">
                    <input type="hidden" id="idTrabajo" value="{{ $trabajo->id }}">
                    <input type="hidden" name="modificado" id="modificado" value="0">
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <a href="" class="btn btn-secondary btn-xs " data-toggle="modal" data-target="#editar">Editar</a>
                </div>

            </div>
            <p><strong>Iniciado: </strong> {{$trabajo->diferencia()}}</p>
            <hr>
            <label for="" class="">Productos Utilizados</label>
            <div class="row d-flex justify-content-around">
                <div class="col-md-5 ">
                    <label for="">Almacen</label>
                    <select name="almacen_id" id="almacen_id" class="js-example-basic-single form-control" required>
                        <option value="" selected disabled>--Seleccione--</option>
                        @foreach ($almacenes as $almacen)
                        <option value="{{$almacen->id}}">{{$almacen->denominacion}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="row d-flex justify-content-around py-3">
                <div class=" col-sm-5">
                    <label for="">Producto</label>
                    <select name="producto" id="producto_id" class="js-example-basic-single form-control">
                        <option value="" selected disabled>--Seleccione--</option>
                        @foreach ($productos as $producto)
                        <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class=" col-sm-2">
                    <label>Cantidad</label>
                    <input type="number" id="cantidad" name="cant" value="" class="form-control"
                        placeholder="Mayor a 0">
                    <div>{{$errors->first('cantidad')}} </div>
                </div>
                <div class=" col-sm-2">
                    <label>Medida</label>
                    <input type="text" id="medida" value="" class="form-control" disabled min="0">
                </div>

                <div class="col-sm-2 d-flex align-items-end">
                    <button type="button" class="addRow btn btn-primary btn-sm"><i class="fas fa-plus "></i></button>
                </div>


                <table class="table table-sm table-bordered my-3 " id="egreso">
                    <thead style="background-color: lightblue ; text-align: center">
                        <tr>
                            <th>Producto</th>
                            <th width="20%">Cantidad</th>
                            <th width="20%">Medida</th>
                            <th width="10%">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                                <td colspan="3" align="center" > <i class="text-muted"> Cargue la lista...</i> </td>
                            </tr> --}}
                    </tbody>
                </table>

            </div>
            <div class="form-group my-5">
                <label for="empleados">Empleados que Intervinieron</label>
                <select name="empleados[]" id="empleados" class="empleados-js form-control" multiple="multiple"
                    required>
                    @foreach($empleados as $empleado)
                    <option value="{{$empleado->id}}">{{$empleado->name}} {{$empleado->apellido}} {{$empleado->dni}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Foto del trabajo finalizado</label>
                <div class="row justify-content-center">
                    <div id="preview">
                    </div>

                    <input class="custom-file" id="imagenTrabajo" type="file" name="fotoFin" accept="image/*"
                        capture="camera" style="" required />
                </div>
            </div>
            <div class="form-group my-5">
                <label for="">Observaciones</label>
                <textarea name="observacion" class="form-control" id="" cols="10" rows="3"></textarea>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>

                {{-- <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm"> --}}
                <button type="submit" class="btn btn-success btn-sm">Terminar</button>
            </div>
        </div>
    </div>
    @csrf
</form>

@endsection

<!-- Modal Edit -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar fecha y hora</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">Fecha de Finalizacion</label>
                <input type="date" id="fechaFin" name="fechaFin" class="form-control" required
                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                    min="{{ Carbon\Carbon::create($trabajo->horaInicio)->format('Y-m-d') }}"
                    max="{{ Carbon\Carbon::now()->format('Y-m-d') }}" id="">

                <label for="">Hora de Finalizacion</label>
                <input type="time" class="form-control" name="horaFin" id="horaFin"
                    value="{{ Carbon\Carbon::now()->format('H:i') }}" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="button" id="comprobarFecha" class="btn btn-primary btn-sm ">Establecer</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('.addRow').on('click',function(){

        addRow();
    });

    function addRow(){
        producto_id = $('#producto_id').val() ;
        almacen_id = $('#almacen_id').val() ;
        producto = "";
        medida = $("#medida").val();
        if(producto_id != null){
            producto = $("#producto_id option:selected").text();
        }
        if(almacen_id != null){
            almacen = $("#almacen_id option:selected").text();
        }
        cantidad = $("#cantidad").val();
        if(almacen_id != null){
            if(producto != "" ){
                if(cantidad > 0){
                    var url = "{{ route('productos.tieneCantidadDisponible', [":idProd", ":idAlmacen" , ":cantidad"]) }}" ;
                    url = url.replace(':idProd' , producto_id) ;
                    url = url.replace(':idAlmacen' , almacen_id) ;
                    url = url.replace(':cantidad' , cantidad) ;
                    $.get(url, function(data){
                        if(data == 1){
                            var fila = '<tr> <td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+'</td>'+
                                        '<td style=" text-align: right"><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+' </td>'+
                                        '<td>'+medida+'</td>'+
                                        '<td style = " text-align: center"><a href="#" class="btn btn-danger btn-xs remove"><i class="fas fa-minus"></i></a></td>' +
                                        '</tr>' ;

                            $('tbody').append(fila) ;
                            limpiar();
                        }else{
                            swal({
                                title: "Error",
                                text: "La cantidad ingresada "+cantidad+" de "+producto+" supera a la existente en el " +almacen,
                                icon: "error",
                            });
                        }

                    });


                }else{
                    swal({
                            title: "Error",
                            text: "Ingrese una cantidad valida y mayor a 0",
                            icon: "error",
                        });
                }
            }else{
                swal({
                            title: "Error",
                            text: "Seleccione un producto",
                            icon: "error",
                        });
            }
        }else {
            swal({
                    title: "Error",
                    text: "Seleccione un Almacen por favor",
                    icon: "error",
            });
        }
    }

    function limpiar(){
		$("#cantidad").val("");
        $("#producto_id").val(null).trigger("change");

	}

    $('body').on('click', '.remove',function(){
        // var last=$('tbody tr').length;
        // if(last==1){
        //     alert("No es posible eliminar la ultima fila");
        // }
        // else{
            $(this).parent().parent().remove();
        //}

    });
</script>
<script>
    $(document).ready(function(){
        $('#producto_id').change(function(){
            var producto_id = $(this).val();
            if(producto_id != null){
                var url = "{{ route('productos.obtenerMedida', ":id") }}" ;
                url = url.replace(':id' , producto_id) ;
                // alert(tip_rec_id) ;
                //AJAX

                $.get(url, function(data){

                    $('#medida').val(data) ;
                });
            } else {
                $('#medida').val('') ;
            }
        });
        $('#comprobarFecha').on('click' , function(){
            var fecha = $('#fechaFin').val();
            var hora = $('#horaFin').val();
            var trabajo = $('#idTrabajo').val();
            // console.log(fecha) ;
            // console.log(hora) ;
            if(fecha != null){
                var direc = "{{ route('trabajos.comprobarFin', [":trabajo" , ":fecha", ":hora"]) }}" ;
                direc = direc.replace(':fecha' , fecha) ;
                direc = direc.replace(':hora' , hora) ;
                direc = direc.replace(':trabajo' ,trabajo ) ;
                // alert(tip_rec_id) ;
                //AJAX

                $.get(direc, function(data){
                    // console.log(data) ;
                    if(data == 1) {
                        var datearray = fecha.split("-");
                        var newdate =   datearray[2] + '/'+ datearray[1] + '/' + datearray[0] ;
                        console.log(newdate);
                        $('#fechaMod').val(newdate.concat(' ' ,hora)) ;
                        $('#fechaFinalizacion').val(newdate.concat(' ' ,hora)) ;
                        $('#modificado').val(1) ;
                        $('#editar').modal('hide');
                        $(".modal-backdrop").remove();

                    }else{
                        swal({
                            title: "Error",
                            text: "La fecha y hora ingresada es menor a la fecha de inicio del trabajo o mayor a la fecha y hora actual!",
                            icon: "error",
                        });
                    }
                });
            } else {

            }
        });
    });

</script>

<script>
    $(document).ready(function() {
        $('.empleados-js').select2();
    });

</script>

<script>
    //cargar imagen local de forma dinamica
    document.getElementById("imagenTrabajo").onchange = function(e) {
            // Creamos el objeto de la clase FileReader
            let reader = new FileReader();

            // Leemos el archivo subido y se lo pasamos a nuestro fileReader
            reader.readAsDataURL(e.target.files[0]);

            // Le decimos que cuando este listo ejecute el código interno
            reader.onload = function(){
                let preview = document.getElementById('preview'),
                image = document.createElement('img');
                image.src = reader.result;
                image.height='240';
                image.width='320';
                preview.innerHTML = '';
                preview.append(image);
            };
    }
</script>

@endpush
