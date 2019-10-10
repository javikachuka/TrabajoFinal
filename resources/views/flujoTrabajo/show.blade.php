@extends('admin_panel.index')

@section('content')
<br>

<div class="row py-3 ">
    <div class="col-md-1">

    </div>
    <div class="col-md-3">
        <div class="info-box mb-4 bg-info">
            <span class="info-box-icon">
                <i class="fal fa-project-diagram"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Flujo de Trabajo</span>

                <span class="info-box-text">{{$flujoTrabajo->nombre}}</span>

            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3>Lista de Estados Posibles</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="" class="table table-sm table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th scope="col">Estado Inicial</th>
                                <th scope="col">Estado Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($flujoTrabajo->transiciones as $tran)
                            <tr>
                                <td>{{$tran->estadoInicial->nombre}}</td>
                                <td>{{$tran->estadoFinal->nombre}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
