@extends('admin_panel.index')

@section('content')

    <div class="card ">
        <div class="card-header">
            <h1>Asistencia de Empleados</h1>
        </div>
        <div class="card-body">
            <div class="text-aling">
                <p>Fecha del Dia: {{ Carbon\Carbon::now()->format('d-m-Y') }}</p> <br>
            </div>

            <div class="text-center">

                <p> Hola {{$user->name}} {{$user->apellido}} <br>
                    Registra tu asistencia por favor!
                </p>

                {{-- <a onclick="activar()"  class="btn btn-primary btn-sm " data-toggle="modal" data-target="#webcam">MARCAR ENTRADA</a> --}}
                <button onclick="activar()" class="btn btn-success btn-sm" data-toggle="modal" data-target="#webcam">MARCAR ENTRADA</button>
                {{-- <button class="btn btn-success" type="submit">MARCAR ENTRADA</button> --}}


                <button class="btn btn-danger btn-sm" type="submit">MARCAR SALIDA</button>
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
                        </tr>
                    </thead>

                <tbody>
                    @if(auth()->user()->asistencias != null)
                        @foreach (auth()->user()->asistencias as $asistencia)
                    <tr>
                                <td>{{$asistencia->getDia()}}</td>
                                <td>{{$asistencia->horaEntrada}}</td>
                                <td>
                                    @if ($asistencia->horaSalida != null)
                                        {{$asistencia->horaSalida}}
                                    @else
                                        Aun no presenta salida.
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


<!-- Modal Create -->
<div class="modal fade" id="webcam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Marcar Entrada</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form class="form-group " method="POST" action="{{route('asistencias.entrada')}}" enctype="multipart/form-data" id="myform">

            <div class="modal-body">
                <div class="text-center">
                    <div id="my_camera"></div>

                    <input type=button class="btn btn-primary btn-xs" value="Tomar Foto" onClick="take_snapshot()">

                    <input type="hidden" name="fotoEntrada" id="foto" value="">
                    {{-- <div class="text-danger">{{$errors->first('fotoEntrada')}} </div> --}}

                    <div id="results"></div>
                </div>

            </div>
                  <div class="modal-footer">
                    <button type="button" onclick="cerrar()" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="button" onclick="comprobar()" class="btn btn-primary btn-sm ">Continuar</button>
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
    function activar(){
		Webcam.set({
			width: 320,
			height: 240,
			image_format: 'jpeg',
			jpeg_quality: 90
		});
        Webcam.attach( '#my_camera' );
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
        if(foto == ""){
            alert('Por favor tome una foto para continuar!') ;

        }else{
            document.getElementById('myform').submit();
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
