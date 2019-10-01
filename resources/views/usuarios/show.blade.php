@extends('admin_panel.index')

@section('content')
    <br>


    <div class="content-fluid">
        <div class="row  justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if (auth()->user()->urlFoto != null)

                                <img src="{{ asset('img/perfiles/'.auth()->user()->urlFoto) }}" class="img-circle elevation-2" alt="User Image">
                            @else
                                <img src="{{ asset('img/perfiles/usuario-sin-foto.png')}}" class="img-circle elevation-2" alt="User Image">

                            @endif
                            <h3 class="profile-username text-center" >{{$user->name . ' ' . $user->apellido}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
