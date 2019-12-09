<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>ReCoop</title>
</head>
<body>
    <p>Hola! Se ha reportado un nuevo trabajo de tipo {{ $data->reclamo->tipoReclamo->nombre }} de prioridad {{$data->reclamo->tipoReclamo->prioridad->nombre}} recibido el {{$data->created_at->format('d/m/Y H:i:s')}}.</p>
    <p>Estos son los datos del socio que ha realizado el reclamo:</p>
    <ul>
        <li>Nombre y Apellido: {{ $data->reclamo->direccion->socio->nombre }} {{ $data->reclamo->direccion->socio->apellido }}</li>
        <li>Nº de Conexion: {{ $data->reclamo->direccion->nro_conexion }}</li>
        <li>DNI: {{ $data->reclamo->direccion->socio->dni }}</li>
    </ul>
    <p>Y se encuentra en la direccion:</p>
    <ul>
        <li>Calle: {{ $data->reclamo->direccion->calle }}</li>
        <li>Altura: {{ $data->reclamo->direccion->altura }}</li>
        <li>Zona: {{ $data->reclamo->direccion->zona->nombre }}</li>
    </ul>
</body>
</html>
