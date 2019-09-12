
<div class="container">
        <h2>Datos del Producto</h2>
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

        <div class="form-group">
                <label>Cantidad Minima</label>
                <input type="text" name="cantidadMinima" value="{{ old('cantidadMinima') ?? $producto->cantidadMinima }} "  class="form-control">
                <div class="text-danger">{{$errors->first('cantidadMinima')}} </div>
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

    @csrf
