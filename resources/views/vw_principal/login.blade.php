@extends('layouts.app')

@section('content')

<div class="text-center">
    @guest
    <div>
        Hola estas en el inicio del sistema!!!!
    </div>
    @endguest
    
</div>
    
@endsection
