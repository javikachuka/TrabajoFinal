<!DOCTYPE html>
<html lang="en">
        <meta name="csrf-token" content="{{ csrf_token() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>ReCoop</title>

  <!-- Font Awesome Icons -->
  {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('admin_panel/plugins/fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin_panel/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin_panel/plugins/datatables-select/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('admin_panel/plugins/select2/css/select2.css')}}" >
<link rel="stylesheet" href="{{asset('admin_panel/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}" >
<link rel="stylesheet" href="{{asset('admin_panel/plugins/chart.js/Chart.min.css')}}" >
  <!-- IonIcons -->
  {{-- <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin_panel/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/animacion.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('css/temaPace.css') }}"> --}}



  <link rel="stylesheet" href="{{asset('admin_panel/plugins/sweetalert2/sweetalert2.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> --}}


  <style>

  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #000001;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px;
    }

  </style>

</head>

<body class="hold-transition sidebar-mini ">
        <div class="wrapper">
            <!-- Inicio Header -->
            @include('admin_panel/header')
            <!-- Fin Header -->
            <!-- Inicio SideBar -->
            @include('admin_panel/sidebar')
            <!-- Fin SideBar -->
            <!-- Inicio ContentWrapper -->

            <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    {{-- <div class="content-header">
                      <div class="container-fluid">
                        <div class="row mb-2">
                          <div class="col-sm-6">
                            <h1 class="m-0 text-dark">HOlesss</h1>
                          </div><!-- /.col -->
                          <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active">Dashboard v3</li>
                            </ol>
                          </div><!-- /.col -->
                        </div><!-- /.row -->
                      </div><!-- /.container-fluid -->
                    </div> --}}
                    <div class="content">
                        @yield('content')
                    </div>
            </div>


            <!-- Fin ContentWrapper -->
            <!-- Inicio Footer -->
            @include('admin_panel/footer')
            <!-- Fin Footer -->

        </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <!-- jQuery -->
    <script src="{{asset('admin_panel/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admin_panel/plugins/jquery/jquery.mask.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('admin_panel/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE -->
    <script src="{{asset('admin_panel/dist/js/adminlte.js')}}"></script>
    <!-- DataTables -->
    <script src="{{asset('admin_panel/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin_panel/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admin_panel/plugins/select2/js/select2.js')}}"></script>
    <script src="{{asset('admin_panel/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{asset('admin_panel/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script>
        const Confirmar = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'success',
        title: 'Guardado!',
        })
        const Cancelar = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'error',
        title: 'No es posible la accion!',
        })
        const Borrado = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'success',
        title: 'Borrado!',
        })
        const Alerta = Swal.mixin({
        toast: false,
        showConfirmButton: false,
        type: 'error',
        title: 'Verifique los campos',
        })
        const Eliminar = Swal.mixin({
        title: 'Seguro que deseas eliminar?',
        text: "No hay vuelva atras.",
        toast: false,
        showConfirmButton: true,
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Si, borrar!',
        })


    </script>

    <script src="{{asset('js/sweetalert.min.js')}}"></script>

    <script src="{{asset('admin_panel/plugins/moment/moment-with-locales.min.js')}}"></script>
    <script src="{{asset('admin_panel/plugins/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admin_panel/dist/js/demo.js')}}"></script>
    {{-- <script src="{{asset('js/pace.js')}}"></script> --}}


    @include('sweet::alert')
    @stack('scripts')
</body>
</html>
