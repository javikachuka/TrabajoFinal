@extends('admin_panel.index')

@section('content')

<div width="50%">
    {!! $estadisAlmacen->container() !!}
</div>
<div class="content">
    <div class="row d-flex justify-content-end">
        <div class="col-md-1 ">
            <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#elegir">Generar <i
                    class=" fa fa-file-pdf"></i></button>
        </div>
    </div>
</div>

<br>
<!-- Modal Create -->
<div class="modal fade" id="elegir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seleccione un Almacen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-group " method="GET" action="{{route('productosUtilizados.pdf')}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Almacen</label>
                        <select name="almacen_id" class="form-control" required>
                            @foreach ($almacenes as $almacen)
                            <option value="{{$almacen->id}}" >{{$almacen->denominacion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger btn-sm ">Generar <i
                            class=" fa fa-file-pdf"></i></button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>


{!! $estadisAlmacen->script() !!}
@endsection
@push('scripts')

@endpush
