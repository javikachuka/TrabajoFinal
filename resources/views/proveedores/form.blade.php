
<div class="container-fluid">
    <div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-success">
            <div class="card-header">
                    <h2 class="card-title">Datos del Proveedor</h2>
            </div>
            <div class="card-body">
                <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre') ?? $proveedor->nombre }}" class="form-control">
                        <div class="text-danger">{{$errors->first('nombre')}} </div>
                </div>
                <div class="form-group">
                        <label>CUIT</label>
                        <input type="text" id="cuit" name="cuit" value="{{ old('cuit') ?? $proveedor->cuit }}" class="form-control">
                        <div class="text-danger">{{$errors->first('cuit')}} </div>
                </div>
                <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" value="{{ old('email') ?? $proveedor->email }}"  class="form-control">
                        <div class="text-danger">{{$errors->first('email')}} </div>
                </div>
                <div class="form-group">
                        <label>Telefono</label>
                        <input type="text" id="telefono" name="telefono" value="{{ old('telefono') ?? $proveedor->telefono }}" class="form-control">
                        <div class="text-danger">{{$errors->first('telefono')}} </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@csrf
