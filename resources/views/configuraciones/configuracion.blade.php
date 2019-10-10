@extends('admin_panel.index')

@section('content')

{{-- <div class="card">
    <div class="card-header p-2">
        <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class=" active tab-pane" id="activity">
                je
            </div>
            <div class="tab-pane">
jo
            </div>
        </div>
    </div>
</div> --}}

<div class="card">
    <div class="card-header">
        <h3>Configuracion del Sistema</h3>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">General</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">Tipos de Comprobantes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                    aria-controls="contact" aria-selected="false">Tipos de Movimientos</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <br>
                <div class="row d-flex justify-content-end">
                    <a href="#" id="editar">Editar <i class="fal fa-edit"></i></a>
                </div>
                <form class="form-group " method="POST" action="{{route('configuraciones.update')}}"
                    enctype="multipart/form-data">
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Nombre de la Empresa</label>
                        <input type="text" disabled class="form-control" name="nombre" id="nombre"
                            value="{{$config->nombre}}">
                    </div>
                    <div class="form-group">
                        <label for="">Direccion de la Empresa</label>
                        <input type="text" disabled class="form-control" name="direccion" id="direccion"
                            value="{{$config->direccion}}">
                    </div>
                    <div class="form-group">
                        <label for="">Telefono</label>
                        <input type="text" disabled class="form-control" name="telefono" id="telefono"
                            value="{{$config->telefono}}">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" disabled class="form-control" name="email" id="email"
                            value="{{$config->email}}">
                    </div>
                    <div class="form-group">
                        <label for="">Logo de la Empresa</label>
                        <div class="row justify-content-center">
                            <img src="{{asset('img/'.$config->logo)}}" alt="" width="80" height="50">
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div id="preview">

                            </div>
                        </div>
                        <br>
                        <input type="file" disabled class="" id="logoEmpresa" name="logo">
                    </div>
                    <div class="row justify-content-end">
                        <button type="submit" class="btn btn-success btn-sm" disabled
                            id="actualizar">Actualizar</button>
                    </div>
                    @csrf
                </form>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-sm" id="tipoComprobantes">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Comprobante</th>
                                    <th width="10%">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comprobantes as $comprobante)
                                <tr>
                                    <td>
                                        {{$comprobante->id}}
                                    </td>
                                    <td>
                                        {{$comprobante->nombre}}
                                    </td>
                                    <td>
                                        <a href="#" id="editar"><i class="fal fa-edit"></i></a>
                                        <a href="#" id="editar"><i class="fal fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
    $('#editar').click(function(){
        $('#nombre').prop('disabled', false);
        $('#direccion').prop('disabled', false);
        $('#telefono').prop('disabled', false);
        $('#email').prop('disabled', false);
        $('#logoEmpresa').prop('disabled', false);
        $('#actualizar').prop('disabled', false);
    });
</script>

{{-- <script>
    $('#editarComprobante').click(function(){
        $('.editable ').attr("contenteditable" , "true");
    });

</script> --}}

<script>
    @if(session('confirmar'))
                Confirmar.fire() ;
            @elseif(session('cancelar'))
                Cancelar.fire();
            @elseif(session('borrado'))
                Borrado.fire();
            @endif
</script>

<script>
    //cargar imagen local de forma dinamica
        document.getElementById("logoEmpresa").onchange = function(e) {
                // Creamos el objeto de la clase FileReader
                let reader = new FileReader();

                // Leemos el archivo subido y se lo pasamos a nuestro fileReader
                reader.readAsDataURL(e.target.files[0]);

                // Le decimos que cuando este listo ejecute el código interno
                reader.onload = function(){
                    let preview = document.getElementById('preview'),
                    image = document.createElement('img');
                    image.src = reader.result;
                    image.height='50';
                    image.width='80';
                    preview.innerHTML = '';
                    var html = 'Nuevo logo: ' ;
                    preview.append(html);
                    preview.append(image);
                };
        }
</script>

@endpush
