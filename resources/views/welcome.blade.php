<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Carros - Iniciar Sesión</title>
</head>
<body>
    <h1>Gestión de Carros - Iniciar Sesión</h1>
    <button>
        <a href="{{ route('auth.google.redirect') }}" style="text-decoration:none; color:black">Iniciar sesión con Google</a>
    </button>

    <br/><small>Fecha actual: {{ date('d-m-y H:i:s', time()); }}</small>
</body>
</html>