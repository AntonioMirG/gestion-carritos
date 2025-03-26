<?php

header('content-type: application/json; charset=utf-8');

$pdo = new PDO("mysql:dbname=gestion_carritos;host=127.0.0.1", "root", "");


//Seleccionar eventos
$sql = $pdo->prepare("SELECT * FROM reserva");
$sql->execute();

$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

// Aquí deberías asegurarte de que las claves coincidan con los nombres de las columnas
foreach ($resultado as $evento) {
    $eventoData = [
        'title' => $evento['Titulo'], // Usar 'Titulo' en lugar de 'titulo'
        'start' => $evento['Fecha_Hora_Inicio'], // Usar 'Fecha_Hora_Inicio'
        'end' => $evento['Fecha_Hora_Fin'], // Usar 'Fecha_Hora_Fin'
        'description' => $evento['description'], // Usar 'description'
        'profesor' => $evento['ID_Profesor'], // Usar 'ID_Profesor' si es necesario
        'carro' => $evento['ID_Carro'], // Usar 'ID_Carro'
        'numeroOrdenadores' => $evento['Numero de ordenadores'], // Usar 'Numero de ordenadores'
        'color' => '#c95832' // Color predeterminado, puedes modificar según lo que necesites
    ];
    $eventos[] = $eventoData;
}

// Se devuelve el resultado como JSON
echo json_encode($eventos);
