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

                                    <div class="col-md-7">
                                        <div class="form-group">
                                                <label for="">Proveedor</label>
                                                <select class="js-example-basic-single" name="proveedor_id">
                                                        @foreach ($proveedores as $proveedor)
                                                            <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                                                        @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Fecha</label>
                                            <div class="form-group">
                                                    <input type="date" name="fecha" required value=""  id="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Num. Comprobante</label>
                                            <input type="text" name="numero_comprobante" required value=""  class="form-control" placeholder="ejemplo 0001">
                                            <div>{{$errors->first('numero_comprobante')}} </div>
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                <div class="col-md-12 ">
                                    <div class="card">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-4">
                                                            <label for="">Producto</label>
                                                                <select name="producto_id" id="producto_id" class="form-control" required>
                                                                        @foreach ($productos as $producto)
                                                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                                        @endforeach
                                                                </select>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-2">
                                                            <label>Cantidad</label>
                                                            <input type="text" id="cantidad" name="cantidad" required value=""  class="form-control" placeholder="Mayor a 0">
                                                            <div>{{$errors->first('cantidad')}} </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-2">

                                                            <label>Precio</label>
                                                            <input type="text" name="precio" id="precio" required value=""  class="form-control" placeholder="$">
                                                            <div>{{$errors->first('precio')}} </div>
                                                    </div>

                                                    <div class="col-xs-12 col sm-4">
                                                            <label for="">Almacen</label>
                                                            <select name="almacen_id" id="almacen_id" class="form-control" required>
                                                                    @foreach ($almacenes as $almacen)
                                                                        <option value="{{$almacen->id}}">{{$almacen->denominacion}}</option>
                                                                    @endforeach
                                                            </select>
                                                    </div>

                                                        <a href="#"  class="addRow btn btn-primary"><i class="fas fa-plus"></i></a>


                                                    <div class="col-md-12">
                                                            <table class="table table-bordered" style="margin-top: 10px">
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
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @csrf
                                <div class="text-left">
                                        <input type="reset" value="Limpiar" class="btn btn-secondary">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </form>
                        </div>
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
        almacen_id = $("#almacen_id").val();
        almacen = $("#almacen_id option:selected").text();

        var fila = '<tr> <td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+'</td>'+
                    '<td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+' </td>'+
                    '<td><input type="hidden" name="precio[]" value="'+precio+'">'+precio+' </td>'+
                    '<td><input type="hidden" name="almacen_id[]" value="'+almacen_id+'">'+almacen+'</td>' +
                    '<td><a href="#" class="btn btn-danger remove"><i class="fas fa-minus"></i></a></td>' +
                    '</tr>' ;

        $('tbody').append(fila) ;
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

@endpush
