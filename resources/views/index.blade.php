<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Carros - Lista de Reservas</title>
</head>
<body>
    <h1>Gestión de Carros - Lista de Reservas</h1>
    <p>Has iniciado sesión como: {{ auth()->user()->name }}</p>

    <a href="{{ route('reservas.create') }}">Reservar carro</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <hr/>

    @foreach ($reservas as $reserva)
        <div>
            <h1>{{$reserva->carro}}</h1>
            <p>Reserva inicio: {{$reserva->inicio}}</p>
            <p>Reserva fin: {{$reserva->fin}}</p>
            <p>Reservado por: {{$reserva->profesor}}</p>
            <!--Cambiar "Admin" por el nombre del usuario administrador-->
            @if(auth()->user()->name === $reserva->profesor || auth()->user()->name === "Admin")
                <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Borrar reserva</button>
                </form>
            @endif
        </div>
        <hr/>
    @endforeach

    <a href="{{ route('reservas.cerrarSesion') }}">Cerrar sesión</a>
    <br/><small>Fecha actual: {{ date('d-m-y H:i:s', time()); }}</small>
</body>
</html>