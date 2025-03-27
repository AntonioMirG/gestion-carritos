<?php
header('Content-Type: application/json');

$pdo = new PDO("mysql:dbname=gestion_carritos;host=127.0.0.1", "root", "");

// Determinar la acción (obtener eventos o crear reserva)
$action = isset($_GET["action"]) ? $_GET["action"] : (isset($_POST["action"]) ? $_POST["action"] : null);

if ($action === "getOptions") {
    // Obtener opciones para profesores y carros
    $profesores = [];
    $carros = [];

    // Obtener los profesores
    $sqlProfesores = "SELECT ID_Profesor, Nombre FROM profesor";
    $stmtProfesores = $pdo->query($sqlProfesores);
    while ($row = $stmtProfesores->fetch(PDO::FETCH_ASSOC)) {
        $profesores[] = $row;
    }

    // Obtener los carros
    $sqlCarros = "SELECT ID_Carro, Nombre FROM carro";
    $stmtCarros = $pdo->query($sqlCarros);
    while ($row = $stmtCarros->fetch(PDO::FETCH_ASSOC)) {
        $carros[] = $row;
    }

    echo json_encode(["success" => true, "profesores" => $profesores, "carros" => $carros]);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear nueva reserva
    $ID_Profesor = $_POST["profesor"];
    $ID_Carro = $_POST["carro"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $numeroOrdenadores = $_POST["numeroOrdenadores"];
    $fechaInicio = $_POST["fechaInicio"];
    $fechaFin = $_POST["fechaFin"];

    // Preparar y ejecutar la inserción de la nueva reserva
    $sqlInsert = "INSERT INTO reserva (ID_Profesor, ID_Carro, Titulo, description, Numero_de_ordenadores, Fecha_Hora_Inicio, Fecha_Hora_Fin) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $pdo->prepare($sqlInsert);
    $resultInsert = $stmtInsert->execute([$ID_Profesor, $ID_Carro, $titulo, $descripcion, $numeroOrdenadores, $fechaInicio, $fechaFin]);

    // Devolver la respuesta
    if ($resultInsert) {
        echo json_encode(["success" => true, "message" => "Reserva creada con éxito"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al crear la reserva: " . $stmtInsert->errorInfo()[2]]);
    }
} else {
    // Obtener los eventos para el calendario
    $sqlEvents = "SELECT ID_Profesor, ID_Carro, Titulo, description, Numero_de_ordenadores, Fecha_Hora_Inicio, Fecha_Hora_Fin FROM reserva";
    $stmtEvents = $pdo->query($sqlEvents);

    $events = [];
    while ($row = $stmtEvents->fetch(PDO::FETCH_ASSOC)) {
        $events[] = [
            "ID_Profesor" => $row["ID_Profesor"],
            "ID_Carro" => $row["ID_Carro"],
            "title" => $row["Titulo"],
            "start" => $row["Fecha_Hora_Inicio"],
            "end" => $row["Fecha_Hora_Fin"],
            "description" => $row["description"],
            "numeroOrdenadores" => $row["Numero_de_ordenadores"]
        ];
    }

    // Devolver los eventos como JSON
    echo json_encode($events);
}
?>
