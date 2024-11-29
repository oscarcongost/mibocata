<?php
header('Content-Type: application/json');

require 'models/Usuario.php';
require 'models/Cocina.php';

$usuario = new Usuario();
$cocina = new Cocina();

$success = true;
$msg = "Usuario válido";
$data = [];

$input = json_decode(file_get_contents("php://input"), true);

if (isset($input["filter"])) {
    $filter = $input["filter"];
    $correo = $filter[0]["correo"] ?? null;
    $pass = $filter[1]["pass"] ?? null;
    $rol = $filter[2]["rol"] ?? null;

    if ($correo && $pass && $rol) {
        if ($rol === "cocina") {
            if ($cocina->validarCredenciales($correo, $pass, $rol)) {
                echo json_encode(["success" => true, "msg" => "Usuario de cocina válido"]);
            } else {
                echo json_encode(["success" => false, "msg" => "Usuario no encontrado en cocina"]);
            }
        } else {
            if ($usuario->validarCredenciales($correo, $pass)) {
                echo json_encode(["success" => true, "msg" => "Usuario de alumno válido"]);
            } else {
                echo json_encode(["success" => false, "msg" => "Usuario no encontrado en alumno"]);
            }
        }
    } else {
        echo json_encode(["success" => false, "msg" => "Faltan parámetros"]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "No se recibieron parámetros"]);
}
