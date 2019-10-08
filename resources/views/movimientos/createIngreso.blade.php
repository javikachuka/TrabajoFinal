@extends('admin_panel.index')

@section('content')
    <h1>Ingreso de productos</h1>

    <div class="content-fluid">
            <div class="row  justify-content-center">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <form class="form-group " method="POST" action="/movimientos/ingreso" >
                                <div class="row d-flex justify-content-around">
                                    @if (session()->has('message'))
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}<br/>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="col-md-3">
                                        <label for="">Proveedor</label>
                                        <div class="form-group">
                                                <select class="js-example-basic-single form-control" name="proveedor_id">
                                                        <option value="" selected disabled>--Seleccione un Proveedor--</option>
                                                        @foreach ($proveedores as $proveedor)
                                                            <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                                                        @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2.5">
                                        <div class="form-group">
                                            <label for="">Fecha de Ingreso</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fal fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="date" name="fecha" class="form-control" required value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->format('Y-m-d') }}" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-sm-3">
                                            <label for="">Almacen Destino</label>
                                            <select name="almacenDestino_id" id="almacenDestino_id" class=" js-example-basic-single form-control" required>
                                                    <option value="" selected disabled>--Seleccione un almacen--</option>
                                                    @foreach ($almacenes as $almacen)
                                                        <option value="{{$almacen->id}}">{{$almacen->denominacion}}</option>
                                                    @endforeach
                                            </select>
                                    </div>

                                    <div class=" col-sm-2">
                                            <label for="">Tipo de Movimiento</label>
                                            <select name="tipoMovimiento_id" id="tipoMovimiento" class=" js-example-basic-single form-control" required>
                                                    @foreach ($tipoMovimientos as $tipoMov)
                                                        <option value="{{$tipoMov->id}}">{{$tipoMov->nombre}}</option>
                                                    @endforeach
                                            </select>
                                    </div>



                                </div>

                                <div class="row d-flex justify-content-around">
                                        <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Numero de Comprobante</label>
                                                    <input type="number" name="numeroComprobante" required value=""  class="form-control" placeholder="Nº" min="0">
                                                    <div>{{$errors->first('numero_comprobante')}} </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                    <label for="">Tipo de Comprobante</label>
                                                    <div class="form-group">
                                                            <select class="js-example-basic-single form-control" name="tipoComprobante_id">
                                                                    <option value="" selected disabled>--Seleccione--</option>
                                                                    @foreach ($tiposComprobantes as $tipoComprobante)
                                                                        <option value="{{$tipoComprobante->id}}">{{$tipoComprobante->nombre}}</option>
                                                                    @endforeach
                                                            </select>
                                                    </div>
                                            </div>
                                            <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Fecha del Comprobante</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fal fa-calendar-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input type="date" class="form-control" name="fechaComprobante" required value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->format('Y-m-d') }}" id="">
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
                                                                <select name="producto" id="producto_id" class="js-example-basic-single form-control" >
                                                                        <option value="" selected disabled>--Seleccione--</option>
                                                                        @foreach ($productos as $producto)
                                                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                                        @endforeach
                                                                </select>
                                                    </div>
                                                    <div class=" col-sm-2">
                                                            <label>Cantidad</label>

                                                            <input type="number" id="cantidad" name="cant"  value=""  class="form-control" placeholder="Mayor a 0" min="0">
                                                            <div>{{$errors->first('cantidad')}} </div>
                                                    </div>

                                                    <div class=" col-sm-2">

                                                            <label>PUM</label>
                                                            <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">$</span>
                                                                    </div>
                                                                    <input type="text" name="pum" id="precio"  value=""  class="form-control" placeholder="">
                                                                    <div>{{$errors->first('precio')}} </div>
                                                            </div>
                                                    </div>



                                                    <div class="col-sm-2 d-flex align-items-end">
                                                        <br>
                                                        <a href="#"  class="addRow btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
                                                    </div>


                                                    <div class="col-md-12">
                                                            <table class="table table-bordered table-sm" style="margin-top: 10px ">
                                                                <thead style="background-color: lightblue">
                                                                    <th>Producto</th>
                                                                    <th>Cantidad</th>
                                                                    <th>PUM</th>
                                                                    <th width = "125px">Accion</th>
                                                                    {{-- <th>Subtotal</th> --}}
                                                                </thead>

                                                                <tbody>

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
                                        <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm">
                                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
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
        precio = $("#precio").val();

        if(producto != "" ){
            if(cantidad > 0){
                // if(precio > 0){
                    var fila = '<tr> <td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+'</td>'+
                                '<td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+' </td>'+
                                '<td><input type="hidden" name="precio[]" value="'+precio+'">'+precio+' </td>'+
                                '<td><a href="#" class="btn btn-danger btn-xs remove"><i class="fas fa-minus"></i></a></td>' +
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

<script>
        $(document).ready(function(){
            $('#precio').mask('000.000.000.000.000,00', {reverse: true});
        });
</script>
@endpush
