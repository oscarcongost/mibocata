<?php

require_once 'inc/Singleton.php';

class Usuario{
    
    private $id;
    private $correo;
    private $contrasena;
    private $mac;
    private $fecha_baja;
    private $rol;
 
    function __construct($id = null, $correo = null, $contrasena = null, $mac = null, $fecha_baja = null, $rol = null)
    {
       $this->id = $id;
       $this->correo = $correo;
       $this->contrasena = $contrasena;
       $this->mac = $mac;
       $this->fecha_baja = $fecha_baja;
       $this->rol = $rol;
    }
 
    //comprueba si existe el usuario en la db
    public function validarCredenciales($correo, $contrasena)
    {
       $pdo = Singleton::getInstance()->getPDO();
 
       $statement = $pdo->prepare("select * from alumno where correo='$correo' and pass='$contrasena'");
       $statement->execute();
 
       $data = $statement->fetchAll(PDO::FETCH_ASSOC);
       return count($data) > 0;
    }
}