<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de carros - Reservar</title>
</head>
<body>
        <h1>Gestión de carros - Reservar</h1>
        <p>Registrado como: {{ auth()->user()->name }}!</p>

        <a href="{{ route('reservas.index') }}">
            Lista de reservas
        </a>

        <form action="{{ route('reservas.store') }}" method="POST">
            @csrf
            <input type="hidden" name="profesor" value="{{ auth()->user()->name }}"/>
            <label>Carro:</label>
            <select name="carro" required>
                <option value="carro1">Carro 1</option>
                <option value="carro2">Carro 2</option>
                <option value="carro3">Carro 3</option>
                <option value="carro4">Carro 4</option>
            </select>

            <label>Hora inicio:</label>
            <select name="horaInicio" required>
                <option value="08:30">Primera</option>
                <option value="09:25">Segunda</option>
                <option value="10:35">Tercera</option>
                <option value="11:30">Cuarta</option>
                <option value="12:25">Quinta</option>
                <option value="13:20">Sexta</option>
            </select>

            <label>Hora fin:</label>
            <select name="horaFin" required>
                <option value="08:30">Primera</option>
                <option value="09:25">Segunda</option>
                <option value="10:35">Tercera</option>
                <option value="11:30">Cuarta</option>
                <option value="12:25">Quinta</option>
                <option value="13:20">Sexta</option>
            </select>

        <button type="submit">Reservar</button>
    </form>

    <a href="{{ route('reservas.cerrarSesion') }}">
        Cerrar sesión
    </a>
</body>
</html>