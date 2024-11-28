<?php
    // Llamada a las clases necesarias
    require_once("../config/conexion.php");
    require_once("../models/Notificacion.php");
    require_once("../models/Usuario.php");
    $notificacion = new Notificacion();
    $usuario = new Usuario();


    // Asegurarse de que el usuario esté autenticado
    if (!isset($_SESSION["Enlace"])) 
    {
        echo json_encode(["error" => "No autenticado"]);
        exit();
    }


    switch ($_GET["op"]) 
    {
        case "MostrarNotificacionCampana":

        if($_SESSION['id_rol']== 3)
        {
            $datos = $notificacion->get_notificacion_Administradores($_SESSION["Enlace"]);   
        }
        else
        {
            $datos = $notificacion->get_notificacion_del_User($_SESSION["Enlace"]);
        }

        if (is_array($datos) && count($datos) > 0) 
        {
            $row = $datos[0];
    
            $output = array(
                "not_id" => $row["not_id"],
                "usu_id" => $row["usu_id"],
                "not_mensaje" => $row["not_mensaje"] . ' ' . $row["tick_id"],
                "tick_id" => $row["tick_id"]
            );
    
            echo json_encode($output);
        } else 
        {
            echo json_encode(["error" => "No se encontraron notificaciones"]);
        }
        break;


        case "listar":

            if($_SESSION['id_rol']== 3)
            {
                $datos = $notificacion->get_notificacion_Administradores($_SESSION["Enlace"]);   
            }
            else
            {
                $datos = $notificacion->get_notificacion_del_User($_SESSION["Enlace"]);
            }

            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["not_mensaje"] . ' ' . $row["tick_id"];
                $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ',' . $row["not_id"] . ');" id="' . $row["tick_id"] . '" class="btn btn-inline btn-info btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
        break;

            case "actualizar":
                $notificacion->update_notificacion_estado_read($_POST["not_id"]);
                break;
    }

?>
