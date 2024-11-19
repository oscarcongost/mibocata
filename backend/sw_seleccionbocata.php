<?php
require 'inc/auth.inc.php';

header("Content-type: application/json; charset=utf-8");
$input = json_decode(file_get_contents("php://input"), true);

if(isset($input)){
    $action = $input["action"];
}

if($action === "cerrar_sesion"){
    session_unset(); // Eliminar todas las variables de sesión
    session_destroy(); // Destruir la sesión

    // Enviar una respuesta de éxito en formato JSON
    echo json_encode(['success' => true]);
    exit;
}
?>