<?php
session_start();

if(!isset($_SESSION['correo'])){
    $json = [
        "success" => false,
        "msg" => "No tienes permiso para acceder a esta página",
    ];
    echo json_encode($json);
    session_destroy();
    exit();
} 
?>