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

        <a href="{{ route('reservas.index') }}">Ir a la lista de reservas</a>

        <form action="{{ route('reservas.store') }}" method="POST">
            @csrf
            <br/>
            
            <input type="hidden" name="profesor" value="{{ auth()->user()->name }}"/>
            <label>Carro:</label>
            <select name="carro" required>
                <option value="Carro 1">Carro 1</option>
                <option value="Carro 2">Carro 2</option>
                <option value="Carro 3">Carro 3</option>
                <option value="Carro 4">Carro 4</option>
            </select><br/>

            <label>Fecha y hora de inicio:</label>
            <input type="datetime-local" name="inicio"/><br/>

            <label>Fecha y hora de fin:</label>
            <input type="datetime-local" name="fin"/><br/>

        <button type="submit">Reservar</button>
        @if(session('error'))
            <p style="color:red">{{ session('error') }}</p>
        @endif
    </form><br/>

    <a href="{{ route('reservas.cerrarSesion') }}">Cerrar sesión</a>
    <br/><small>Fecha actual: {{ date('d-m-y H:i:s', time()); }}</small>
</body>
</html>