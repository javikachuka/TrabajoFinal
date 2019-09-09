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
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group">
                                                <label for="">Almacen</label>
                                                <select name="almacen_id" class="form-control" required>
                                                    <option value="0" disabled>--Seleccione un almacen--</option>
                                                        @foreach ($almacenes as $almacen)
                                                            <option value="{{$almacen->id}}">{{$almacen->denominacion}}</option>
                                                        @endforeach
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group">
                                                <label for="">Proveedor</label>
                                                <select name="proveedor_id" class="form-control" required>
                                                    <option value="0" selected>--Seleccione un proveedor--</option>
                                                        @foreach ($proveedores as $proveedor)
                                                            <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                                                        @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <label for="">Fecha</label>
                                        <div class="form-group">
                                                <input type="date" name="fecha" required value=""  id="">
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
                                                                <select name="producto_id" class="form-control" required>
                                                                    <option value="0" selected>--Seleccione un producto--</option>
                                                                        @foreach ($productos as $producto)
                                                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                                        @endforeach
                                                                </select>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-2">

                                                            <label>Cantidad</label>
                                                            <input type="text" name="cantidad" required value=""  class="form-control" placeholder="Mayor a 0">
                                                            <div>{{$errors->first('cantidad')}} </div>
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
