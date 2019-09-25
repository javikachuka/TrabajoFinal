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


                <button class="btn btn-success" type="submit">MARCAR ENTRADA</button>


                <button class="btn btn-danger" type="submit">MARCAR SALIDA</button>
            </div>


            <hr>
            <label for=""></label>
            <table class="table table-striped">
                    <thead>
                        Asistencia
                        <tr>
                            <th>Tipo</th>
                            <th>Hora</th>
                        </tr>
                    </thead>

                <tbody>
                    <tr>
                        <td>Entrada</td>
                        <td>14:00hs</td>
                    </tr>
                    <tr>
                        <td>Salida</td>
                        <td>16:00hs</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
@push('scripts')
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
