<?php
  //Cadena de conexion 
  require_once("../config/conexion.php"); 
  //Ruta Login
  $conexion = new Conectar(); // Crear una instancia de la clase Conectar
  header("Location:" . $conexion->ruta() . "index.php");
?>