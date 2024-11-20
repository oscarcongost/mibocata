<?php
require 'inc/auth.inc.php';
require 'inc/Singleton.php';

header("Content-type: application/json; charset=utf-8");
$input = json_decode(file_get_contents("php://input"), true);

if (isset($input)) {
    $action = $input["action"];
}

if ($action === "cerrar_sesion") {
    session_unset();
    session_destroy();

    echo json_encode(['success' => true]);
    exit;
}

if ($action === "listar") {
    // Obtener el día del input
    $dia = $input['dia']; // El día es pasado desde el frontend

    $pdo = Singleton::getInstance()->getPDO();

    // Consulta para obtener los bocadillos del día
    $sql = "SELECT * FROM bocadillo WHERE dia_venta = '$dia' ORDER BY tipo";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $bocadillos = $stmt->fetchAll();

    // Devolver los bocadillos en formato JSON
    echo json_encode(['success' => true, 'bocadillos' => $bocadillos]);
    exit;
}
