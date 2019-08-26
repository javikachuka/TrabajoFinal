<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SiSGeS - @yield('title')</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<!--  asi se hacen los comentarios-->
	<nav class=" navbar navbar-expand-lg navbar-light nav bg-dark ">
		<div class="navbar-header">
			<a class="navbar-brand text-white" href="{{route('home')}}">SiSGeS</a>
		</div>
		<a class="nav-link active" href="{{action("SocioController@index")}}">Socios</a>
		<a class="nav-link" href="{{action("ReclamoController@index")}}">Reclamos</a>
		<a class="nav-link" href="#">Trabajos</a>
		<a class="nav-link" href="{{action("EmpleadoController@index")}}">Empleados</a>
		<a class="nav-link" href="#">Productos</a>
		<a class="nav-link" href="#">Proveedores</a>
	</nav>

	<div class="container" >
		@yield('content')
	</div>
	
</body>
</html>