@extends('admin_panel.index')

@section('content')

<div class="card ">
    <div class="card-header">
        <h1>Asistencia de Empleados</h1>
    </div>
    <div class="card-body">
        <div class="text-aling">
            <p>Fecha y hora del Dia: {{ Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p> <br>
        </div>

        <div class="text-center">

            <p> Hola {{$user->name}} {{$user->apellido}} <br>
                Registra tu asistencia por favor!
            </p>
            <input type="hidden" id="idLogueo" value="{{$user->id}}">
            {{-- <a onclick="activar()"  class="btn btn-primary btn-sm " data-toggle="modal" data-target="#webcam">MARCAR ENTRADA</a> --}}
            <button onclick="activar()" class="btn btn-success btn-sm" data-toggle="modal" data-target="#webcam">MARCAR
                ENTRADA</button>
            {{-- <button class="btn btn-success" type="submit">MARCAR ENTRADA</button> --}}


            <button class="btn btn-danger btn-sm" type="submit" data-toggle="modal" data-target="#salida">MARCAR
                SALIDA</button>
        </div>
        {{-- <div id="my_camera"></div>

            <form>
                    <input type=button class="btn btn-primary btn-xs" value="Take Snapshot" onClick="take_snapshot()">
            </form>

            <div id="results">Your captured image will appear here...</div> --}}


        <hr>
        <label for=""></label>
        <table class="table table-striped">
            <thead>
                Entradas y Salidas
                <tr>
                    <th>Fecha</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Foto</th>
                </tr>
            </thead>

            <tbody>
                @if($asistencias != null)
                @foreach ($asistencias as $asistencia)
                <tr>
                    <td>{{$asistencia->getDia()}}</td>
                    <td>
                        @if($asistencia->horaEntrada != null)
                        {{$asistencia->horaEntrada}}
                        @else
                        Sin Registros.
                        @endif
                    </td>
                    <td>
                        @if ($asistencia->horaSalida != null)
                        {{$asistencia->horaSalida}}
                        @else
                        Sin Registros.
                        @endif
                    </td>
                    <td style="text-align: center">
                        @if($asistencia->urlFoto != null)
                        <img src="{{asset('img/asistencias/'.$asistencia->urlFoto)}}" alt="" height="60" width="60">
                        @else
                        ---
                        @endif
                    </td>
                </tr>
                @endforeach
                @else

                @endif
            </tbody>
        </table>
    </div>
</div>


<!-- Modal Entrada -->
<div class="modal fade" id="webcam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-group " method="POST" action="{{route('asistencias.entrada')}}"
                enctype="multipart/form-data" id="myform">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Marcar Entrada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="camara-tab" data-toggle="tab" href="#camara" role="tab"
                            aria-controls="camara" aria-selected="true">Camara</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="dni-tab" data-toggle="tab" href="#dni" role="tab"
                            aria-controls="dni" aria-selected="false">DNI</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="camara" role="tabpanel" aria-labelledby="camara-tab">
                        <div class="modal-body">
                            <div class="text-center">
                                <div id="my_camera" class="justify-content-center">
                                </div>

                                <input type="button" id="botonFoto" class="btn btn-primary btn-xs" value="Tomar Foto"
                                    onClick="take_snapshot()">

                                <input type="hidden" name="fotoEntrada" id="foto" value="">
                                {{-- <div class="text-danger">{{$errors->first('fotoEntrada')}}
                            </div> --}}

                            <div id="results"></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade " id="dni" role="tabpanel" aria-labelledby="dni-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>DNI</label>
                                <input type="text" id="dniID" name="dni" required value="{{ old('dni') }}"
                                    class="form-control disabled" data-mask="00.000.000" placeholder="Ingrese su dni por favor!" disabled>
                                <div class="text-danger">{{$errors->first('dni')}} </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>



        <div class="modal-footer">
            <button type="button" onclick="cerrar()" class="btn btn-secondary btn-sm"
                data-dismiss="modal">Cerrar</button>
            <button type="button" onclick="comprobar()" class="btn btn-primary btn-sm ">Continuar</button>
        </div>
        @csrf
        </form>
    </div>
</div>
</div>

<!-- Modal Salida-->
<div class="modal fade" id="salida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Marcar Salida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="form-group " method="POST" action="{{route('asistencias.salida')}}"
                enctype="multipart/form-data" id="myform">

                <div class="modal-body">
                    <strong><i class="fal fa-exclamation-circle mr-1"></i>Atencion</strong>
                    <p>Al marcar salida automaticamente se deslogueara del sistema!
                    </p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-sm ">Continuar</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>


@endsection
@push('scripts')

<script type="text/javascript" src="{{asset('webcamjs/webcam.min.js')}}"></script>

<script language="JavaScript">
    Webcam.on('error',function(err){
        $('#dni-tab').removeClass('disabled') ;
        $('#botonFoto').attr('disabled', true) ;
        $('#dniID').attr('disabled', false) ;
        $('#my_camera').append('<span class="text-danger">Error en la cámara. Por favor registre su entrada con su dni en la pestaña DNI</span>') ;

    }) ;
    function activar(){
		Webcam.set({
			width: 320,
			height: 240,
			image_format: 'jpeg',
			jpeg_quality: 90
		});
        Webcam.attach( '#my_camera' );
        // console.log($("#dniID").is("enabled"));
    }

    function take_snapshot() {
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				// display results in page
				document.getElementById('results').innerHTML =
                    '<h2>Foto del Dia:</h2>' +
					'<img src="'+data_uri+'"/>';
                    var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');

                    document.getElementById('foto').value = raw_image_data;
                    // document.getElementById('myform').submit();
                    // Webcam.upload( data_uri, '#', function(code, text) {
                    //     // Upload complete!
                    //     // 'code' will be the HTTP response code from the server, e.g. 200
                    //     // 'text' will be the raw response content
                    // } );
			} );
    }

    function cerrar(){
        Webcam.reset();
    }

    function comprobar(){
        var foto = document.getElementById("foto").value;

        if(!$("#botonFoto").prop("disabled")){
            if(foto == ""){
                swal({
                        title: "Error",
                        text: "Tome una foto para continuar!",
                        icon: "error",
                    });
                // alert('Por favor tome una foto para continuar!') ;

            }else{
                document.getElementById('myform').submit();
            }
        }else{
            var d = $('#dniID').val() ;
            if(d == ""){
                swal({
                        title: "Error",
                        text: "Ingrese su dni por favor!",
                        icon: "error",
                    });
            }else{
                var idlog = $('#idLogueo').val();
                var url = "{{ route('asistencias.comprobarDni', [":dni" , ":id"]) }}" ;
                url = url.replace(':dni' , d) ;
                url = url.replace(':id' , idlog) ;
                // alert(tip_rec_id) ;
                //AJAX

                $.get(url, function(data){

                    // console.log(data) ;
                    if(data == 1){
                        document.getElementById('myform').submit();
                    }else{
                        swal({
                        title: "Error",
                        text: "Error en el dni, ingrese su dni correspondiente por favor!",
                        icon: "error",
                    });
                    }

                });
            }

        }
    }
</script>

<script>
    @if(session('confirmar'))
            Confirmar.fire() ;
        @elseif(session('cancelar'))
            Cancelar.fire();
        @elseif(session('borrado'))
            Borrado.fire();
        @endif
</script>

@endpush
