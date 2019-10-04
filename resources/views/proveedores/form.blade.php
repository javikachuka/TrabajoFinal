


                <div class="form-group">
                        <label>Nombre <i class="text-danger">(*)</i></label>
                        <input type="text" name="nombre" value="{{ old('nombre') ?? $proveedor->nombre }}" class="form-control">
                        <div class="text-danger">{{$errors->first('nombre')}} </div>
                </div>
                <div class="form-group">
                        <label>CUIT <i class="text-danger">(*)</i></label>
                        <input type="text" id="cuit" name="cuit" value="{{ old('cuit') ?? $proveedor->cuit }}" class="form-control">
                        <div class="text-danger">{{$errors->first('cuit')}} </div>
                </div>
                <div class="form-group">
                        <label>Email <i class="text-danger">(*)</i></label>
                        <input type="text" name="email" value="{{ old('email') ?? $proveedor->email }}"  class="form-control">
                        <div class="text-danger">{{$errors->first('email')}} </div>
                </div>
                <div class="form-group">
                        <label>Telefono <i class="text-danger">(*)</i></label>
                        <input type="text" id="telefono" name="telefono" value="{{ old('telefono') ?? $proveedor->telefono }}" class="form-control">
                        <div class="text-danger">{{$errors->first('telefono')}} </div>
                </div>
                <div class="form-group">
                        <label for="">Productos Ofrecidos</label>
                        @foreach ($productos as $producto)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="productos[]" class="custom-control-input" id="checked2{{$producto->id}}" value="{{$producto->id}}" @if($proveedor->productos->contains($producto)) checked @endif>
                                <label class="custom-control-label" for="checked2{{$producto->id}}">{{$producto->nombre}}</label>
                            </div>
                        @endforeach
                </div>
@csrf
