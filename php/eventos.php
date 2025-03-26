<?php
header('Content-Type: application/json');
$pdo = new PDO("mysql:dbname=gestion_carritos;host=127.0.0.1", "root", "");

// Comprobamos si se ha enviado el formulario con datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recogemos los datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $profesor = $_POST['profesor'];
    $carro = $_POST['carro'];
    $numeroOrdenadores = $_POST['numeroOrdenadores'];
    $fechaInicio = $_POST['fechaInicio'];

    // Insertamos los datos en la base de datos
    $sql = "INSERT INTO reserva (Titulo, description, ID_Profesor, ID_Carro, Numero_de_ordenadores, Fecha_Hora_Inicio) 
            VALUES (:titulo, :descripcion, (SELECT ID_Profesor FROM profesor WHERE Nombre = :profesor LIMIT 1), 
            (SELECT ID_Carro FROM carro WHERE Nombre = :carro LIMIT 1), :numeroOrdenadores, :fechaInicio)";
    $stmt = $pdo->prepare($sql);

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
    exit;
}

// Si es una solicitud GET, mostramos los eventos existentes
$sql = $pdo->prepare("SELECT r.Titulo, r.Fecha_Hora_Inicio as start, r.Fecha_Hora_Fin as end, r.description, p.Nombre as profesor, c.Nombre as carro 
                     FROM reserva r 
                     JOIN profesor p ON r.ID_Profesor = p.ID_Profesor 
                     JOIN carro c ON r.ID_Carro = c.ID_Carro");

$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
?>
