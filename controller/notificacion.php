<?php


    // Llamada a las clases necesarias
    require_once("../config/conexion.php");
    require_once("../models/Notificacion.php");
    require_once("../models/Usuario.php");

    // Crear instancias de las clases
    $notificacion = new Notificacion();
    $usuario = new Usuario();

    // Asegurarse de que el usuario esté autenticado
    if (!isset($_SESSION["Enlace"])) {
        echo json_encode(["error" => "No autenticado"]);
        exit();
    }

    // Obtener el ID del usuario desde la sesión
    $usu_id = $_SESSION["Enlace"];

    /* opciones del controlador */
    switch ($_GET["op"]) {
        case "mostrar":
            // Obtener la última notificación
            $datos = $notificacion->get_notificacion_x_usu($usu_id);   
        
            // Si no hay resultados
            if (is_array($datos) && count($datos) > 0) {
                $row = $datos[0]; // Obtiene la primera (más reciente) notificación
        
                $output = array(
                    "not_id" => $row["not_id"],
                    "usu_id" => $row["usu_id"],
                    "not_mensaje" => $row["not_mensaje"] . ' ' . $row["tick_id"], // Mensaje + ticket ID
                    "tick_id" => $row["tick_id"]
                );
        
                // Asegúrate de que sea una respuesta JSON válida
                echo json_encode($output);
            } else {
                // Si no hay notificaciones, responde con un error
                echo json_encode(["error" => "No se encontraron notificaciones"]);
            }
            break;

        case "actualizar":
            // Actualizar el estado de la notificación
            $notificacion->update_notificacion_estado($_POST["not_id"]);
            break;

        case "listar":
            // Obtener las notificaciones para el listado en el datatable
            $datos = $notificacion->get_notificacion_x_usu2($usu_id);
            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["not_mensaje"] . ' ' . $row["tick_id"];
                $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');" id="' . $row["tick_id"] . '" class="btn btn-inline btn-info btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
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
    }
?>
