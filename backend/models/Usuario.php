<?php

require_once 'inc/Singleton.php';

class Usuario
{

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

   // Usuario.php
   public function validarCredenciales($correo, $contrasena)
   {
      $pdo = Singleton::getInstance()->getPDO();

      // Concatenación directa en la consulta
      $statement = $pdo->prepare("SELECT * FROM alumno WHERE correo = '$correo' AND pass = '$contrasena'");
      $statement->execute();

      $data = $statement->fetchAll(PDO::FETCH_ASSOC);

      if (count($data) > 0) {
         session_start();
         $_SESSION["mac"] = $data[0]["mac"];
      }

      return count($data) > 0;
   }
}
