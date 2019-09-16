@extends('admin_panel.index')

@section('content')
    <h1>Ingreso de productos</h1>

    <div class="content-fluid">
            <div class="row  justify-content-center">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <form class="form-group " method="POST" action="/movimientos/ingreso" >
                                <div class="row">
                                    @if (session()->has('message'))
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}<br/>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="col-md-2">
                                        <label for="">Proveedor</label>
                                        <div class="form-group">
                                                <select class="js-example-basic-single form-control" name="proveedor_id">
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
                                                <input type="date" name="fecha" class="form-control" required value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">

                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Num. Comprobante</label>
                                            <input type="text" name="numero_comprobante" required value=""  class="form-control" placeholder="ejemplo 0001">
                                            <div>{{$errors->first('numero_comprobante')}} </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                            <label for="">Tipo de Comprob.</label>
                                            <div class="form-group">
                                                    <select class="js-example-basic-single form-control" name="tipoComprobante_id">
                                                            @foreach ($tiposComprobantes as $tipoComprobante)
                                                                <option value="{{$tipoComprobante->id}}">{{$tipoComprobante->nombre}}</option>
                                                            @endforeach
                                                    </select>
                                            </div>
                                    </div>
                                    <div class="col-md-2.5">
                                            <div class="form-group">
                                                <label for="">Fecha del Comprobante</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fal fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="date" class="form-control" name="fechaComprobante" required value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" id="">
                                                </div>
                                            </div>
                                        </div>


                                </div>
                                <br>
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class=" col-sm-3">
                                                            <label for="">Producto</label>
                                                                <select name="producto_id" id="producto_id" class="js-example-basic-single form-control" required>
                                                                        @foreach ($productos as $producto)
                                                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                                        @endforeach
                                                                </select>
                                                    </div>
                                                    <div class=" col-sm-2">
                                                            <label>Cantidad</label>
                                                            <input type="text" id="cantidad" name="cantidad"  value=""  class="form-control" placeholder="Mayor a 0">
                                                            <div>{{$errors->first('cantidad')}} </div>
                                                    </div>

                                                    <div class=" col-sm-1">

                                                            <label>Precio U.</label>
                                                            <input type="text" name="precio" id="precio"  value=""  class="form-control" placeholder="$">
                                                            <div>{{$errors->first('precio')}} </div>
                                                    </div>

                                                    <div class=" col-sm-2">
                                                            <label for="">Almacen</label>
                                                            <select name="almacenDestino_id" id="almacenDestino_id" class=" js-example-basic-single form-control" required>
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

                                                    <div class="col-sm-2 ">
                                                        <br>
                                                        <a href="#"  class="addRow btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
                                                    </div>


                                                    <div class="col-md-12">
                                                            <table class="table table-bordered table-sm" style="margin-top: 10px">
                                                                <thead style="background-color: #A9D0F5">
                                                                    <th>Producto</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Precio</th>
                                                                    <th>Almacen</th>
                                                                    <th>Opciones</th>
                                                                    {{-- <th>Subtotal</th> --}}
                                                                </thead>
                                                                <tfoot>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tfoot>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                </div>

                                                </div>
                                                <div class="text-right">
                                                        <input type="reset" value="Limpiar" class="btn btn-secondary btn-sm">
                                                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
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
        almacenDestino_id = $("#almacenDestino_id").val();
        almacenDestino = $("#almacenDestino_id option:selected").text();
        tipoMov_id = $("#tipoMovimiento").val();
        tipoMov = $("#tipoMovimiento option:selected").text();

        if(producto != "" && cantidad > 0 && precio > 0){
            var fila = '<tr> <td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+'</td>'+
                        '<td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+' </td>'+
                        '<td><input type="hidden" name="precio[]" value="'+precio+'">'+precio+' </td>'+
                        '<td><input type="hidden" name="almacenDestino_id[]" value="'+almacenDestino_id+'">'+almacenDestino+'</td>' +
                        '<td><input type="hidden" name="tipoMovimiento_id[]" value="'+tipoMov_id+'">'+tipoMov+' </td>'+
                        '<td><a href="#" class="btn btn-danger btn-xs remove"><i class="fas fa-minus"></i></a></td>' +
                        '</tr>' ;

            $('tbody').append(fila) ;
        }else{
            Alerta.fire('Alerta!' , 'Verifique los campos')
        }

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
@endpush
