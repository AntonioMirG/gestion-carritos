<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Carros - Lista de Reservas</title>
</head>
<body>
    <h1>Gestión de Carros - Lista de Reservas</h1>
    <p>Registrado como: {{ auth()->user()->name }}!</p>

    <a href="{{ route('reservas.create') }}">Reservar</a>

    @foreach ($reservas as $reserva)
        <div>
            <h1>{{$reserva->carro}}</h1>
            <p>Horas reservadas: {{$reserva->horaInicio}}-{{$reserva->horaFin}}</p>
            <p>Reservado por: {{$reserva->profesor}}</p>
        </div>
        <hr/>
    @endforeach

    <a href="{{ route('reservas.cerrarSesion') }}">Cerrar sesión</a>
    <br/><small>Hora actual: {{ date('H:i:s', time()); }}</small>
</body>
</html>