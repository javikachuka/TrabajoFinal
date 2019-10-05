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
            <p><strong>Trabajo: </strong> {{$trabajo->reclamo->tipoReclamo->nombre}}</p> <br>
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
                    <input type="text" id="cantidad" name="cant" value="" class="form-control" placeholder="Mayor a 0">
                    <div>{{$errors->first('cantidad')}} </div>
                </div>

                <div class="col-sm-2 d-flex align-items-end">
                    <button type="button" class="addRow btn btn-primary btn-sm"><i class="fas fa-plus "></i></button>
                </div>


                <table class="table table-sm table-bordered my-3 " id="egreso">
                    <thead style="background-color: lightblue">
                        <tr>
                            <th>Producto</th>
                            <th width="20%">Cantidad</th>
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
                {{-- <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm"> --}}
                <button type="submit" class="btn btn-success btn-sm">Terminar</button>
            </div>
        </div>
    </div>
    @csrf
</form>

@endsection

@push('scripts')
<script>
    $('.addRow').on('click',function(){

        addRow();
    });

    function addRow(){
        producto_id = $('#producto_id').val() ;
        producto = "";
        if(producto_id != null){
            producto = $("#producto_id option:selected").text();
        }
        cantidad = $("#cantidad").val();
        if(producto != "" ){
            if(cantidad > 0){
                var fila = '<tr> <td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+'</td>'+
                            '<td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+' </td>'+
                            '<td><a href="#" class="btn btn-danger btn-xs remove"><i class="fas fa-minus"></i></a></td>' +
                            '</tr>' ;

                $('tbody').append(fila) ;
                limpiar();
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
    }

    function limpiar(){
		$("#cantidad").val("");

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
