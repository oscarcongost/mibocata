<?php
header('Content-Type: application/json');

require 'models/Usuario.php';

$usuario = new Usuario();

$success = true;
$msg = "Usuario valido";
$data = [];

//respuesta correcta por defecto 
$json = [
    "success" => $success,
    "msg" => $msg,
    "data" => $data
];

header("Content-type: application/json; charset=utf-8");
$input = json_decode(file_get_contents("php://input"), true);

if(isset($input["filter"])){
    $filter = $input["filter"];
};

$correo = $filter[0]["correo"] ?? null;
$pass = $filter[1]["pass"] ?? null;

if($usuario -> validarCredenciales($correo, $pass)){
    echo json_encode($json);
} else {
    echo json_encode([
        "success" => false,
        "msg" => "Usuario no encontrado"
    ]);
}