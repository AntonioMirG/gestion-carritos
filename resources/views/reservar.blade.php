<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Carros - Reservar</title>
</head>
<body>
        <h1>Gestión de Carros - Reservar</h1>
        <p>Has iniciado sesión como: {{ auth()->user()->name }}</p>

        <a href="{{ route('reservas.index') }}">Lista de reservas</a>

        <form action="{{ route('reservas.store') }}" method="POST">
            @csrf
            <input type="hidden" name="profesor" value="{{ auth()->user()->name }}"/>
            <label>Carro:</label>
            <select name="carro" required>
                <option value="Carro 1">Carro 1</option>
                <option value="Carro 2">Carro 2</option>
                <option value="Carro 3">Carro 3</option>
                <option value="Carro 4">Carro 4</option>
            </select>

            <label>Hora inicio:</label>
            <select name="horaInicio" required>
                <option value="08:30" selected>Primera hora (08:30)</option>
                <option value="09:22">Segunda hora (09:22)</option>
                <option value="10:32">Tercera hora (10:32)</option>
                <option value="11:24">Cuarta hora (11:24)</option>
                <option value="12:34">Quinta hora (12:34)</option>
                <option value="13:26">Sexta hora (13:26)</option>
            </select>

            <label>Hora fin:</label>
            <select name="horaFin" required>
                <option value="09:22">Segunda hora (09:22)</option>
                <option value="10:32">Tercera hora (10:32)</option>
                <option value="11:24">Cuarta hora (11:24)</option>
                <option value="12:34">Quinta hora (12:34)</option>
                <option value="13:26">Sexta hora (13:26)</option>
                <option value="14:16" selected>Fin lectivo (14:16)</option>
            </select>

        <button type="submit">Reservar</button>
    </form>

    <a href="{{ route('reservas.cerrarSesion') }}">Cerrar sesión</a>
    <br/><small>Hora actual: {{ date('H:i:s', time()); }}</small>
</body>
</html>