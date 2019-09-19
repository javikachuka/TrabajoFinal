@extends('admin_panel.index')

@section('content')
    <br>

<br>
    <div class="content-fluid">
        <div class="row  justify-content-center">
            <div class="col-md-8">
                    <h3>Iniciar Trabajo</h3>
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <button class="btn btn-success">Tomar foto</button>
                            <img src="{{asset('admin_panel/dist/img/sinimagen.jpg')}}" alt="">
                            <hr>
                            <button class="btn btn-success" onclick="location.href='{{route('trabajos.iniciarTrabajo', $trabajo)}}'">Continuar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
