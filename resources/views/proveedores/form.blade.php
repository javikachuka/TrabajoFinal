
<div class="container">
    <h2>Datos del Proveedor</h2>
    <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') ?? $proveedor->nombre }}" class="form-control">
            <div class="text-danger">{{$errors->first('nombre')}} </div>
    </div>
    <div class="form-group">
            <label>CUIT</label>
            <input type="text" name="cuit" value="{{ old('cuit') ?? $proveedor->cuit }}" class="form-control">
            <div class="text-danger">{{$errors->first('cuit')}} </div>
    </div>
    <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="{{ old('email') ?? $proveedor->email }}"  class="form-control">
            <div class="text-danger">{{$errors->first('email')}} </div>
    </div>
    <div class="form-group">
            <label>Telefono</label>
            <input type="text" name="telefono" value="{{ old('telefono') ?? $proveedor->telefono }}" class="form-control">
            <div class="text-danger">{{$errors->first('telefono')}} </div>
    </div>

</div>

@csrf
