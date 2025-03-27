<?php
header('Content-Type: application/json');
$pdo = new PDO("mysql:dbname=gestion_carritos;host=127.0.0.1", "root", "");

// Si es una solicitud para obtener profesores y carros
if (isset($_GET['action']) && $_GET['action'] === 'getOptions') {
    try {
        // Obtener los profesores
        $profesoresStmt = $pdo->prepare("SELECT ID_Profesor, Nombre FROM profesor");
        $profesoresStmt->execute();
        $profesores = $profesoresStmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener los carros
        $carrosStmt = $pdo->prepare("SELECT ID_Carro, Nombre FROM carro");
        $carrosStmt->execute();
        $carros = $carrosStmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los datos como JSON
        echo json_encode(['success' => true, 'profesores' => $profesores, 'carros' => $carros]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
    exit;
}

// Comprobamos si se ha enviado el formulario con datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que todos los campos requeridos estén presentes
    $requiredFields = ['titulo', 'descripcion', 'profesor', 'carro', 'numeroOrdenadores', 'fechaInicio'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['success' => false, 'message' => "El campo '$field' es obligatorio"]);
            exit;
        }
    }

    // Recogemos los datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $profesor = $_POST['profesor'];
    $carro = $_POST['carro'];
    $numeroOrdenadores = $_POST['numeroOrdenadores'];
    $fechaInicio = $_POST['fechaInicio'];

    // Insertamos los datos en la base de datos
    $sql = "INSERT INTO reserva (Titulo, description, ID_Profesor, ID_Carro, Numero_de_ordenadores, Fecha_Hora_Inicio) 
            VALUES (:titulo, :descripcion, 
            (SELECT ID_Profesor FROM profesor WHERE Nombre = :profesor LIMIT 1), 
            (SELECT ID_Carro FROM carro WHERE Nombre = :carro LIMIT 1), 
            :numeroOrdenadores, :fechaInicio)";
    $stmt = $pdo->prepare($sql);

    try {
        // Ejecutamos la consulta con los datos
        $stmt->execute([
            ':titulo' => $titulo,
            ':descripcion' => $descripcion,
            ':profesor' => $profesor,
            ':carro' => $carro,
            ':numeroOrdenadores' => $numeroOrdenadores,
            ':fechaInicio' => $fechaInicio
        ]);

        // Respondemos con un mensaje de éxito
        echo json_encode(['success' => true, 'message' => 'Reserva creada exitosamente']);
    } catch (PDOException $e) {
        // Manejo de errores en la base de datos
        echo json_encode(['success' => false, 'message' => 'Error al guardar la reserva: ' . $e->getMessage()]);
    }
    exit;
}

// Si es una solicitud GET, mostramos los eventos existentes
$sql = $pdo->prepare("SELECT r.Titulo, r.Fecha_Hora_Inicio as start, r.Fecha_Hora_Fin as end, r.description, 
                             p.Nombre as profesor, c.Nombre as carro, r.Numero_de_ordenadores as numeroOrdenadores
                     FROM reserva r 
                     JOIN profesor p ON r.ID_Profesor = p.ID_Profesor 
                     JOIN carro c ON r.ID_Carro = c.ID_Carro");

$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// Aseguramos que los datos se devuelvan en el formato adecuado para FullCalendar
$events = [];
foreach ($result as $row) {
    $events[] = [
        'Titulo' => $row['Titulo'],
        'start' => date('Y-m-d\TH:i:s', strtotime($row['start'])),  // Convertir al formato adecuado
        'end' => date('Y-m-d\TH:i:s', strtotime($row['end'])),  // Convertir al formato adecuado
        'description' => $row['description'],
        'profesor' => $row['profesor'],
        'carro' => $row['carro'],
        'numeroOrdenadores' => $row['numeroOrdenadores']
    ];
}

echo json_encode($events);  // Devolver el JSON con los eventos
?>
