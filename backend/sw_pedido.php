<?php
require 'inc/auth.inc.php';
require 'inc/Singleton.php';

header("Content-type: application/json; charset=utf-8");
$input = json_decode(file_get_contents("php://input"), true);

$pdo = Singleton::getInstance()->getPDO();

// Verifica si se envió la acción
if (!isset($input["action"])) {
    echo json_encode(['success' => false, 'message' => 'No se recibió ninguna acción.']);
    exit;
}

$action = $input["action"];

if ($action === "cerrar_sesion") {
    // Cierra la sesión
    session_unset();
    session_destroy();

    echo json_encode(['success' => true, 'message' => 'Sesión cerrada correctamente.']);
    exit;
}

if ($action === "marcar_retirado") {
    // Valida si se envió el ID del pedido
    if (!isset($input["id_pedido"])) {
        echo json_encode(['success' => false, 'message' => 'ID del pedido no proporcionado.']);
        exit;
    }

    $idPedido = $input["id_pedido"];

    try {
        // Marca el pedido como retirado en la base de datos
        $sql = "UPDATE pedidos SET retirado = 1 WHERE id = :id_pedido";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_pedido', $idPedido, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Pedido marcado como retirado.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

if ($action === "listar_pedidos") {
    try {
        // Obtiene todos los pedidos de la base de datos sin filtros ni paginación
        $sql = "SELECT * FROM pedidos ORDER BY fecha DESC, hora ASC";  // Puedes ajustar el ORDER BY si lo necesitas
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si hay pedidos, los envía en formato JSON
        echo json_encode(['success' => true, 'pedidos' => $pedidos]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Si la acción no coincide con las opciones válidas
echo json_encode(['success' => false, 'message' => 'Acción no válida.']);
exit;
