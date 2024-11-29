<?php

require_once 'inc/Singleton.php';

class Cocina
{

    private $email;
    private $mac;
    private $contrasena;
    private $rol;

    function __construct($email = null, $mac = null, $contrasena = null, $rol = null)
    {
        $this->email = $email;
        $this->mac = $mac;
        $this->contrasena = $contrasena;
        $this->rol = $rol;
    }

    // Comprueba si existe el usuario en la DB
    // Cocina.php
    public function validarCredenciales($correo, $pass, $rol)
    {
        $pdo = Singleton::getInstance()->getPDO();

        // Concatenación directa en la consulta
        $sql = "SELECT * FROM usuario WHERE email = '$correo' AND rol = '$rol' AND contraseña = '$pass'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return count($data) > 0;
    }
}
