
<div class="container-fluid">
    <div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-success">
            <div class="card-header">
                    <h2 class="card-title">Datos del Producto</h2>
            </div>
            <div class="card-body">
                <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre') ?? $producto->nombre }}" class="form-control">
                        <div class="text-danger">{{$errors->first('nombre')}} </div>
                </div>
                <div class="form-group">
                        <label>Codigo</label>
                        <input type="text" name="codigo" value="{{ old('codigo') ?? $producto->codigo }}" class="form-control">
                        <div class="text-danger">{{$errors->first('codigo')}} </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label>Cantidad Minima</label>
                                <input type="text" name="cantidadMinima" value="{{ old('cantidadMinima') ?? $producto->cantidadMinima }} "  class="form-control">
                                <div class="text-danger">{{$errors->first('cantidadMinima')}} </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label >Medida</label>
                        <select name="medida_id" class=" form-control" >
                            @foreach ($medidas as $medida)
                                <option value="{{$medida->id}}">{{$medida->nombre}} <i class="text-muted">({{$medida->simbolo}})</i></option>
                            @endforeach
                        </select>
                        <div class="text-danger">{{$errors->first('rubro_id')}} </div>
                    </div>
                </div>
                <div class="form-group">
                        <label >Categoria</label>
                        <select name="rubro_id" class=" form-control" >
                                @foreach ($rubros as $rubro)
                                    <option value="{{$rubro->id}}">{{$rubro->nombre}}</option>
                                @endforeach
                        </select>
                        <div class="text-danger">{{$errors->first('rubro_id')}} </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@csrf
