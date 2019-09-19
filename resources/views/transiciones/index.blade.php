@extends('admin_panel.index')

@section('content')
<h1>Transiciones</h1>
@if (session()->has('message'))
<div class="alert alert-danger">
    Error  {{session('message')}}
</div>
@endif
<br>



    <div class="row">

        <div class="col-md-4">
            <div class="info-box mb-3 bg-info">
                <span class="info-box-icon">
                    <i class="fal fa-project-diagram"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Flujo de Trabajo</span>

                    <span class="info-box-text">{{$flujoTrabajo->nombre}}</span>

                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-info card-outline">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nombre de la Transicion</label>
                        <input type="text" name="nombre" id="nombre" required   class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Estado Inicial</label>
                                <div class="form-group">
                                    <select name="estadoInicial_id" id="estadoInicial_id" class="form-control" required>
                                            @foreach ($estados as $estado)
                                                <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                            @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <label>Estado Final</label>
                            <div class="form-group">
                                <select name="estadoFinal_id" id="estadoFinal_id" class="form-control" required>
                                        @foreach ($estados as $estado)
                                            <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                        <div class="text-right">
                                <button href="#" class="addRow btn btn-success btn-sm">Asignar Transicion</button>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    <hr>


<h4 class="font-weight-light">Lista de Transiciones Asignadas</h2>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
        <form class="form-group " method="POST" action="/transiciones/{{$flujoTrabajo->id}}" >
            <table id="users" class="table table-sm table-bordered table-striped table-hover datatable">
                <thead>
                <tr>
                    <th scope="col">Transicion</th>
                    <th scope="col">Estado Inicial</th>
                    <th scope="col">Estado Final</th>
                    <th scope="col">Posicion</th>
                    <th scope="col">Accion</th>
                </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($flujoTrabajo->transiciones as $tran)
                        <tr>
                        <td><input type="hidden" name="nombre[]" value="{{$tran->nombre}}">{{$tran->nombre}}</td>
                        <td><input type="hidden" name="estadoInicial_id[]" value="{{$tran->estadoInicial->id}}">{{$tran->estadoInicial->nombre}}</td>
                        <td><input type="hidden" name="estadoFinal_id[]" value="{{$tran->estadoFinal->id}}">{{$tran->estadoFinal->nombre}}</td>
                        <td>
                            <a href="#" class="up"><i class="fas fa-caret-up"></i></a> <a href="#" class="down"><i class="fas fa-caret-down"></i></a></td>
                        <td width="75px"><a href="#" class="btn btn-danger btn-xs remove"><i class="fas fa-minus"></i></a></td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
            <div class="text-right">
                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>
            </div>
            @csrf
        </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('.addRow').on('click',function(){
        addRow();
    });

    function addRow(){
        //Obtener los valores de los inputs
        nombre = $('#nombre').val() ;
        estadoInicial_id = $("#estadoInicial_id").val();
        estadoInicial = $("#estadoInicial_id option:selected").text();
        estadoFinal_id = $("#estadoFinal_id").val();
        estadoFinal = $("#estadoFinal_id option:selected").text();


        if((nombre != "") && (estadoInicial != estadoFinal)){
            var fila = '<tr> ' +
                        '<td><input type="hidden" name="nombre[]" value="'+nombre+'">'+nombre+'</td>'+
                        '<td><input type="hidden" name="estadoInicial_id[]" value="'+estadoInicial_id+'">'+estadoInicial+'</td>' +
                        '<td><input type="hidden" name="estadoFinal_id[]" value="'+estadoFinal_id+'">'+estadoFinal+' </td>'+
                        '<td><a href="#" class="up"> <i class="fas fa-caret-up"></i> </a><a href="#" class="down"> <i class="fas fa-caret-down"> </a></td> ' +
                        '<td><a href="#" class="btn btn-danger btn-xs remove"><i class="fas fa-minus"></i></a></td>' +
                        '</tr>' ;

            $('tbody').append(fila) ;
        }else{
            Alerta.fire('Alerta!', 'Verifique los campos.')
        }

        }


    $('body').on('click', '.remove',function(){
        // var last=$('tbody tr').length;
        // if(last==1){
        //     alert("No es posible eliminar la ultima fila");
        // }
        // else{
            $(this).parent().parent().remove();
        //}

    });
</script>
<script>
        @if(session('confirmar'))
            Confirmar.fire() ;
        @elseif(session('cancelar'))
            Cancelar.fire();
        @endif
</script>
<script>
$(document).ready(function(){
    $(".up,.down").click(function(){
        var row = $(this).parents("tr:first");
        if ($(this).is(".up")) {
            row.insertBefore(row.prev());
        } else {
            row.insertAfter(row.next());
        }
    });
});

</script>
@endpush

