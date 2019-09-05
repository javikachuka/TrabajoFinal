@extends('admin_panel.index')

@section('content')
    <br>


    <div class="content-fluid">
        <div class="row  justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img src="{{asset('admin_panel/dist/img/avatar5.png')}}" alt="">
                            <h3 class="profile-username text-center" >{{$user->name . ' ' . $user->apellido}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
