<?php
require 'inc/auth.inc.php';
require 'inc/Singleton.php';

$pdo = Singleton::getInstance()->getPDO();
$input = json_decode(file_get_contents("php://input"), true);

if (isset($input)) {
    $action = $input["action"];
}

if ($action === "cerrar_sesion") {
    session_unset();
    session_destroy();
    echo json_encode(['success' => true]);
    exit();
}

if (isset($input["action"])) {

    if ($input["action"] === "listar_pedidos") {
        try {
            $fechaHoy = date("Y-m-d");

            $sql = "SELECT * FROM pedidos WHERE fecha = '$fechaHoy' ORDER BY fecha DESC, hora ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'pedidos' => $pedidos]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al obtener los pedidos: ' . $e->getMessage()]);
        }
        exit();
    }

   
    if ($input["action"] === "actualizar_retirado" && isset($input["id"]) && isset($input["retirado"])) {
        try {
            $id = (int)$input["id"];
            $retirado = (int)$input["retirado"]; 

            $sql = "UPDATE pedidos SET retirado = $retirado WHERE id = $id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente.']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el pedido: ' . $e->getMessage()]);
        }
        exit();
    }

    // Acción no válida
    echo json_encode(['success' => false, 'message' => 'Acción no válida.']);
    exit();
}
