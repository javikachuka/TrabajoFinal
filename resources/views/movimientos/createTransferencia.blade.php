@extends('admin_panel.index')

@section('content')
    <h1>Transferencia de Productos</h1>

    <div class="content-fluid">
            <div class="row  justify-content-center">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <form class="form-group " method="POST" action="/movimientos/transferencia" >
                                <div class="row">
                                    @if (session()->has('msg'))
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}<br/>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Fecha de Transferencia</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-calendar-alt"></i>
                                                </span>
                                                <input type="date" name="fecha" required value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}" id="">
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
                                                    <div class=" col-sm-2">
                                                            <label for="">Producto</label>
                                                                <select name="producto_id" id="producto_id" class="js-example-basic-single form-control" required>
                                                                        @foreach ($productos as $producto)
                                                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                                        @endforeach
                                                                </select>
                                                    </div>
                                                    <div class=" col-sm-2">
                                                            <label>Cantidad</label>
                                                            <input type="text" id="cantidad" name="cantidad" required value=""  class="form-control" placeholder="Mayor a 0">
                                                            <div>{{$errors->first('cantidad')}} </div>
                                                    </div>

                                                    <div class=" col-sm-3">
                                                            <label for="">Almacen de Origen</label>
                                                            <select name="otro" id="almacenOrigen_id" class=" js-example-basic-single form-control" required>
                                                                    @foreach ($almacenes as $almacen)
                                                                        <option value="{{$almacen->id}}">{{$almacen->denominacion}}</option>
                                                                    @endforeach
                                                            </select>
                                                    </div>

                                                    <div class=" col-sm-3">
                                                            <label for="">Almacen de Destino</label>
                                                            <select name="otro2" id="almacenDestino_id" class=" js-example-basic-single form-control" required>
                                                                    @foreach ($almacenes as $almacen)
                                                                        <option value="{{$almacen->id}}">{{$almacen->denominacion}}</option>
                                                                    @endforeach
                                                            </select>
                                                    </div>

                                                    <div class="col-1.5 ">
                                                        <a href="#"  class="addRow btn btn-primary btn-xs"><i class="fas fa-plus"></i></a>
                                                    </div>


                                                    <div class="col-md-12">
                                                            <table class="table table-bordered" style="margin-top: 10px">
                                                                <thead style="background-color: #A9D0F5">
                                                                    <th>Producto</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Desde</th>
                                                                    <th>Hasta</th>
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
                                                <div class="text-left">
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
        almacenOrigen_id = $("#almacenOrigen_id").val();
        almacenOrigen = $("#almacenOrigen_id option:selected").text();
        almacenDestino_id = $("#almacenDestino_id").val();
        almacenDestino = $("#almacenDestino_id option:selected").text();

        if(almacenOrigen_id != almacenDestino_id && cantidad>0){
            var fila = '<tr> <td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+'</td>'+
                        '<td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+' </td>'+
                        '<td><input type="hidden" name="almacenOrigen_id[]" value="'+almacenOrigen_id+'"><span class="badge badge-info">'+almacenOrigen+'</span></td>' +
                        '<td><input type="hidden" name="almacenDestino_id[]" value="'+almacenDestino_id+'"><span class="badge badge-info">'+almacenDestino+'</span></td>' +
                        '<td><a href="#" class="btn btn-danger btn-xs remove"><i class="fas fa-minus"></i></a></td>' +
                        '</tr>' ;

            $('tbody').append(fila) ;
        }else{
            Alerta.fire('Alerta!', 'Verifique los campos.')
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

@endpush
