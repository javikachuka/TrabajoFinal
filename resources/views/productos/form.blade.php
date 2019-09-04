
<div class="container">
        <h2>Datos del Producto</h2>
        <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') ?? $producto->nombre }}" class="form-control">
                <div>{{$errors->first('nombre')}} </div>
        </div>
        <div class="form-group">
                <label>Codigo</label>
                <input type="text" name="codigo" value="{{ old('codigo') ?? $producto->codigo }}" class="form-control">
                <div>{{$errors->first('codigo')}} </div>
        </div>
        <div class="form-group">
                <label>Cantidad</label>
                <input type="number" name="cantidad" value="{{ old('cantidad') ?? $producto->cantidad }} " min="0" class="form-control">
                <div>{{$errors->first('cantidad')}} </div>
        </div>
        <div class="form-group">
                <label>Cantidad Minima</label>
                <input type="number" name="cantidadMinima" value="{{ old('cantidadMinima') ?? $producto->cantidadMinima }} " min="0" class="form-control">
                <div>{{$errors->first('cantidadMinima')}} </div>
        </div>
        <div class="form-group">
                <label >Categoria</label>
                <select name="categoria_id" class="form-control" >
                    <option value="0" selected >--Seleccione una categoria--</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                        @endforeach
                </select>
        </div>
    </div>

    @csrf
