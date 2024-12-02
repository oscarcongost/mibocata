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

    public function validarCredenciales($correo, $pass, $rol)
    {
        $pdo = Singleton::getInstance()->getPDO();

        $sql = "SELECT * FROM usuario WHERE email = '$correo' AND rol = '$rol' AND contraseña = '$pass'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($data) > 0) {
            session_start();
            $_SESSION["mac"] = $data[0]["mac"];
        }

        return count($data) > 0;
    }
}
