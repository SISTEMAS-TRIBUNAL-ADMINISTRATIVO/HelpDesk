<?php
    require_once("../config/conexion.php");
    require_once("encryptController.php");
    require_once("../models/Usuario.php");
    $usuario = new Usuario();


    if (isset($_GET['Session_start'])) 
    {
        $datos=$usuario->Autorizacion($_GET['Session_start']);  

        if(is_array($datos)==true and count($datos)>0)
        {
            foreach($datos as $row)
            {
                $_SESSION['id_usuario']=$row['id_usuario'];
                $_SESSION['nombre']=$row['nombre'];
                $_SESSION['paterno']=$row['paterno'];
                $_SESSION['materno']=$row['materno'];
                $_SESSION['email']=$row['email'];
                $_SESSION['siglas']=$row['siglas'];
                $_SESSION['PASSWORD']=$row['PASSWORD'];
                $_SESSION['token']=$row['token'];
                $_SESSION['Enlace']=$row['Enlace'];
                $_SESSION['id_rol']=$row['id_rol'];
                $_SESSION['rol']=$row['rol'];
                $_SESSION['descripcion_rol']=$row['descripcion_rol'];
                $_SESSION['id_sistema']=$row['id_sistema'];
                $_SESSION['sistema']=$row['sistema'];
                $_SESSION['alias']=$row['alias'];
                $_SESSION['url_declaracion']=$row['url_declaracion'];
                $_SESSION['IdPadreSistema']=$row['IdPadreSistema'];
            }
            $conexion = new Conectar(); 
            header("Location:" . $conexion->rutaHelpdesk() . "view/Home/index.php");
        }
        else
        {
            echo "Falla";
        }
    } 
?>