@extends('admin_panel.index')

@section('content')
    <h1>Transferencia de Productos</h1>

    <div class="content-fluid">
            <div class="row  justify-content-center">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <form class="form-group " method="POST" action="/movimientos/transferencia" >
                                <div class="row d-flex justify-content-around">
                                    @if (session()->has('msg'))
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}<br/>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="col-md-2.5">
                                        <div class="form-group">
                                            <label for="">Fecha de Transferencia</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-calendar-alt"></i>
                                                </span>
                                                <input type="date" class="form-control" name="fecha" required value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" id="">
                                            </div>
                                        </div>
                                    </div>


                                    <div class=" col-sm-3">
                                            <label for="">Almacen de Origen</label>
                                            <select name="almacenOrigen_id" id="almacenOrigen_id" class=" js-example-basic-single form-control" required>
                                                    <option value="" selected disabled>--Seleccione un almacen--</option>
                                                    @foreach ($almacenes as $almacen)
                                                        <option value="{{$almacen->id}}">{{$almacen->denominacion}}</option>
                                                    @endforeach
                                            </select>
                                    </div>

                                    <div class=" col-sm-3">
                                            <label for="">Almacen de Destino</label>
                                            <select name="almacenDestino_id" id="almacenDestino_id" class=" js-example-basic-single form-control" required>
                                                    <option value="" selected disabled>--Seleccione un almacen--</option>
                                                    @foreach ($almacenes as $almacen)
                                                        <option value="{{$almacen->id}}">{{$almacen->denominacion}}</option>
                                                    @endforeach
                                            </select>
                                    </div>


                                    <div class="col-md-3">
                                        <label>Tipo de Movimiento</label>
                                            <div class="form-group">
                                                    <select name="tipoMovimiento_id" id="tipoMovimiento" class=" js-example-basic-single form-control" required>
                                                            @foreach ($tipoMovimientos as $tipoMov)
                                                                <option value="{{$tipoMov->id}}">{{$tipoMov->nombre}}</option>
                                                            @endforeach
                                                    </select>
                                                    <div>{{$errors->first('tipoMovimiento_id')}} </div>
                                            </div>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">


                                            <div class="form-group">
                                                <div class="row">
                                                    <div class=" col-sm-4">
                                                            <label for="">Producto</label>
                                                                <select name="producto" id="producto_id" class="js-example-basic-single form-control" >
                                                                        @foreach ($productos as $producto)
                                                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                                        @endforeach
                                                                </select>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class=" col-sm-2">
                                                            <label>Cantidad</label>
                                                            <input type="text" id="cantidad" name="cant"  value=""  class="form-control" placeholder="Mayor a 0">
                                                            <div>{{$errors->first('cantidad')}} </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-sm-2 d-flex align-items-end">
                                                            <br>
                                                            <a href="#"  class="addRow btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
                                                    </div>


                                                    <div class="col-md-12">
                                                            <table class="table table-bordered" style="margin-top: 10px">
                                                                <thead style="background-color: #A9D0F5">
                                                                    <th>Producto</th>
                                                                    <th>Cantidad</th>
                                                                    <th width="125px">Opciones</th>
                                                                    {{-- <th>Subtotal</th> --}}
                                                                </thead>
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
        if(cantidad>0){
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
