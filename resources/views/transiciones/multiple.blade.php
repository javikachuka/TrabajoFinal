@extends('admin_panel.index')

@section('content')


    <div class="container">
        <h2>Carga de Transiciones a un flujo</h2>
        <h4>{{$flujoTrabajo->nombre}}</h4>
        <div class="row">
            <form  method="POST" action="/transiciones">
                <section>

                    <div class="form-group">

                        <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre de Transicion</th>
                                        <th>Estado Inicial</th>
                                        <th>Estado Final</th>
                                        <th><a href="#" class="addRow"><i class="fas fa-plus"></i></a></th>
                                    </tr>
                                </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="nombre[]" class="form-control" required placeholder="nombre de la transicion">
                                </td>
                                <td>
                                    <select name="estadoInicial[]" class="form-control" required>
                                                @foreach ($estados as $estado)
                                                    <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                                @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="estadoFinal[]" class="form-control" required>
                                                    @foreach ($estados as $estado)
                                                        <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                                    @endforeach
                                    </select>
                                </td>
                                <td><a href="#" class="btn btn-danger btn-xs remove"><i class="fas fa-minus"></i></a></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                </section>
                <div class="text-right">
                        <input type="reset" value="Limpiar" class="btn btn-secondary">
                        <button type="submit" class="btn btn-success">Guardar</button>
                </div>
                @csrf
            </form>
        </div>
    </div>

</body>

</html>
@endsection
@push('scripts')
    <script>
          $('.addRow').on('click',function(){
                addRow();
            });
            function addRow()
            {
                var tr='<tr>'+
                '<td> <input type="text" name="nombre[]" class="form-control" required placeholder="nombre de la transicion"> </td>'+
                '<td> <select name="estadoInicial[]" class="form-control" required> <option value="0" selected>--Seleccione un estado--</option> @foreach ($estados as $estado) <option value="{{$estado->id}}">{{$estado->nombre}}</option> @endforeach </select> </td>'+
                '<td> <select name="estadoFinal[]" class="form-control" required> <option value="0" selected>--Seleccione un estado--</option> @foreach ($estados as $estado) <option value="{{$estado->id}}">{{$estado->nombre}}</option> @endforeach </select> </td>'+
                '<td><a href="#" class="btn btn-danger remove"><i class="fas fa-minus"></i></a></td>'+
                '</tr>';
                $('tbody').append(tr);
            };

            $('body').on('click', '.remove',function(){
                var last=$('tbody tr').length;
            if(last==1){
                alert("No es posible eliminar la ultima fila");
            }
            else{
                $(this).parent().parent().remove();
            }

            });
    </script>
@endpush
