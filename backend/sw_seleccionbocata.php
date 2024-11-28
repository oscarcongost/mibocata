<?php
require 'inc/auth.inc.php';
require 'inc/Singleton.php';

header("Content-type: application/json; charset=utf-8");
$input = json_decode(file_get_contents("php://input"), true);
$horaActual = time();
$horaFormateada = date("H:i:s",$horaActual);
$macAlumno = $_SESSION["mac"];
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

    $dia = $input['dia'];
    $pdo = Singleton::getInstance()->getPDO();

    $sql = "SELECT * FROM bocadillo WHERE dia_venta = '$dia' ORDER BY tipo";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $bocadillos = $stmt->fetchAll();

    echo json_encode(['success' => true, 'bocadillos' => $bocadillos]);
    exit;
}

if ($action === "añadirpedido") {

    if (isset($input["pedido"])) {
        
        $pedido = $input["pedido"];
        $alumno_mac = $macAlumno;
        $bocadillo_nombre = $pedido["bocadillo_nombre"];
        $fecha = date("Y-m-d");
        $hora = $horaFormateada;
        $retirado = $pedido["retirado"];
        
        $pdo = Singleton::getInstance()->getPDO();

        $sql = "INSERT INTO pedidos (alumno_mac, bocadillo_nombre, fecha, hora, retirado) 
                VALUES ('$alumno_mac', '$bocadillo_nombre', '$fecha', '$hora', '$retirado')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Pedido añadido correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se ha recibido un pedido']);
    }
    exit;
}
