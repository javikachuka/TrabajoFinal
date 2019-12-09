@extends('admin_panel.index')

@section('content')

<div class="content-fluid">
    <div class="row  justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3>Edicion de Pedido</h3>
                </div>
                <div class="card-body box-profile">
                    <form class="form-group " method="POST" action="{{route('pedidos.update', $pedido)}}">
                        @method('PUT')
                        <div class="row d-flex justify-content-around">
                            @if (session()->has('message'))
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                {{ $error }}<br />
                                @endforeach
                            </div>
                            @endif
                            <div class="col-md-3">
                                <label for="">Nº de Pedido</label>
                                <input type="text" disabled class="form-control" value="{{$pedido->id}}">
                            </div>
                            <div class="col-md-3">
                                <label for="">Proveedor</label>
                                <div class="form-group">
                                    <select class="js-example-basic-single form-control" name="proveedor_id" required>
                                        <option value="" selected disabled>--Seleccione un Proveedor--</option>
                                        @foreach ($proveedores as $proveedor)
                                        <option value="{{$proveedor->id}}" @if($pedido->proveedor != null)
                                            @if($pedido->proveedor->id == $proveedor->id)
                                            selected
                                            @endif
                                            @endif>{{$proveedor->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fecha de Pedido</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fal fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="date" name="fecha" class="form-control" required
                                            value="{{$pedido->fecha}}" disabled id="">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="row d-flex justify-content-around">
                                                <div class=" col-sm-3">
                                                    <label for="">Producto</label>
                                                    <select name="producto" id="producto_id"
                                                        class="js-example-basic-single form-control">
                                                        <option value="" selected disabled>--Seleccione--</option>
                                                        @foreach ($productos as $producto)
                                                        <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class=" col-sm-2">
                                                    <label>Cantidad</label>

                                                    <input type="number" id="cantidad" name="cant" value=""
                                                        class="form-control" placeholder="Mayor a 0" min="0">
                                                    <div>{{$errors->first('cantidad')}} </div>
                                                </div>
                                                <div class=" col-sm-2">
                                                    <label>Medida</label>
                                                    <input type="text" id="medida" value="" class="form-control"
                                                        disabled min="0">
                                                </div>


                                                <div class="col-sm-2 d-flex align-items-end">
                                                    <br>
                                                    <a href="#" class="addRow btn btn-primary btn-sm"><i
                                                            class="fas fa-plus"></i></a>
                                                </div>


                                                <div class="col-md-12">
                                                    <table class="table table-bordered table-sm"
                                                        style="margin-top: 10px ">
                                                        <thead
                                                            style="background-color: lightblue ; text-align: center;">
                                                            <th>Producto</th>
                                                            <th>Cantidad</th>
                                                            <th>Medida</th>
                                                            <th width="125px">Accion</th>
                                                            {{-- <th>Subtotal</th> --}}
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($pedido->detalles as $detalle)
                                                            <tr>
                                                                <td>
                                                                    <input type="hidden" name="producto_id[]"
                                                                        value="{{$detalle->producto->id}}">
                                                                    {{$detalle->producto->nombre}}
                                                                </td>
                                                                <td style="text-align:end;">
                                                                    <input type="hidden" name="cantidad[]"
                                                                        value="{{$detalle->cantidad}}">
                                                                    {{$detalle->cantidad}}
                                                                </td>
                                                                <td>
                                                                    {{$detalle->producto->medida->nombre}}
                                                                </td>
                                                                <td style="text-align:center;">
                                                                    <a href="#" class="btn btn-danger btn-xs remove"><i
                                                                            class="fas fa-minus"></i></a></td>
                                                            </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <a href="javascript:history.back()" class="btn btn-primary btn-sm">Volver</a>
                            <button type="submit" class="btn btn-success btn-sm">Confirmar</button>
                        </div>
                </div>
                @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('.addRow').on('click',function(){
        addRow();
    });

    function addRow(){
        //Obtener los valores de los inputs
        producto_id = $('#producto_id').val() ;
        producto = $("#producto_id option:selected").text();
        cantidad = $("#cantidad").val();
        medida = $("#medida").val();


        if(producto_id != null ){
            if(cantidad > 0){
                // if(precio > 0){
                    var fila = '<tr> <td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+'</td>'+
                                '<td style="text-align:right;"><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+' </td>'+
                                '<td>'+medida+'</td>'+
                                '<td style="text-align:center;"><a href="#" class="btn btn-danger btn-xs remove"><i class="fas fa-minus"></i></a></td>' +
                                '</tr>' ;

                    $('tbody').append(fila) ;
                    limpiar();
                // }else{
                //     swal({
                //         title: "Error",
                //         text: "Ingrese un precio valido y mayor a 0",
                //         icon: "error",
                //     });
                // }
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
		$("#precio").val("");
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
        });

</script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>

<script>
    @if(session('confirmar'))
        Confirmar.fire() ;
    @elseif(session('cancelar'))
        Cancelar.fire();
    @endif
</script>
@endpush
