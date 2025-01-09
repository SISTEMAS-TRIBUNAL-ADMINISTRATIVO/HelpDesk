<?php
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    switch($_GET["op"]){
        case "guardaryeditar":
            if(empty($_POST["usu_id"])){       
                $usuario->insert_usuario($_POST["usu_nom"],$_POST["usu_ape"],$_POST["usu_correo"],$_POST["usu_pass"],$_POST["rol_id"]);     
            }
            else {
                $pass_encrip = md5($_POST["usu_correo"]).hash('sha256',$_POST["usu_pass"]);
                $usuario->update_usuario($_POST["usu_id"],$_POST["usu_nom"],$_POST["usu_ape"],$_POST["usu_correo"],$pass_encrip,$_POST["rol_id"]);
            }
        break;

        case "listar":
            $datos=$usuario->get_usuario();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["usu_nom"];
                $sub_array[] = $row["usu_ape"];
                $sub_array[] = $row["usu_correo"];
                $sub_array[] = $row["usu_pass"];

                if ($row["rol_id"]=="4"){
                    $sub_array[] = '<span class="label label-pill label-success">Usuario</span>';
                }else if($row["rol_id"]=="3"){
                    $sub_array[] = '<span class="label label-pill label-info">Administrador</span>';
                }

                $sub_array[] = '<button type="button" onClick="editar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "eliminar":
            $usuario->delete_usuario($_POST["usu_id"]);
        break;

        case "mostrar";
            $datos=$usuario->get_usuario_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["usu_id"] = $row["usu_id"];
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["usu_correo"] = $row["usu_correo"];
                    $output["usu_pass"] = $row["usu_pass"];
                    $output["rol_id"] = $row["rol_id"];
                }
                echo json_encode($output);
            }   
        break;

        case "total";
            if( $_SESSION["id_rol"]==3)
            {
                $datos=$usuario->get_ticket_todos();
            } else
            {
                $datos=$usuario->get_usuario_total_x_id($_SESSION["Enlace"]);  
            }
        
            if(is_array($datos)==true and count($datos)>0)
            {
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalabierto";
            if( $_SESSION["id_rol"]==3)
            {
                $datos=$usuario->get_ticket_abiertotodos();
            } else
            {
                $datos=$usuario->get_usuario_totalabierto_x_id($_SESSION["Enlace"]);
            }  
                if(is_array($datos)==true and count($datos)>0){
                    foreach($datos as $row)
                    {
                        $output["TOTAL"] = $row["TOTAL"];
                    }
                    echo json_encode($output);
                }
        break;

        case "totalcerrado";
            if( $_SESSION["id_rol"]==3)
            {
                $datos=$usuario->get_usuario_totalcerradotodos();
            } else
            {
                $datos=$usuario->get_usuario_totalcerrado_x_id($_SESSION["Enlace"]);
            }  
                
                if(is_array($datos)==true and count($datos)>0)
                {
                    foreach($datos as $row)
                    {
                        $output["TOTAL"] = $row["TOTAL"];
                    }
                    echo json_encode($output);
                }
        break;

        case "grafico";
            if( $_SESSION["id_rol"]==3)
            {
                $datos=$usuario->get_Todos_grafico();  
            } else
            {
                $datos=$usuario->get_usuario_grafico($_SESSION["Enlace"]);  
            }  
            echo json_encode($datos);
        break;


        case "comboUserSoporte";
            $datos = $usuario->comboUserSoporte();
            $html ="";
            if(is_array($datos)==true and count($datos)>0)
            {
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['Enlace']."'>".$row['nombre']."</option>";
                }
                echo $html;
            }
        break;


        case "UserActivoSession":

           $Repuesta['id_usuario'] =  $_SESSION['id_usuario'];
           $Repuesta['nombre'] =  $_SESSION['nombre'];
           $Repuesta['paterno'] =  $_SESSION['paterno'];
           $Repuesta['materno'] =  $_SESSION['materno'];
           $Repuesta['email'] =  $_SESSION['email'];
           $Repuesta['siglas'] =  $_SESSION['siglas'];
           $Repuesta['PASSWORD'] =  $_SESSION['PASSWORD'];
           $Repuesta['token'] =  $_SESSION['token'];
           $Repuesta['Enlace'] =  $_SESSION['Enlace']; 
           $Repuesta['id_rol'] =  $_SESSION['id_rol'];
           $Repuesta['rol'] =  $_SESSION['rol'];
           $Repuesta['descripcion_rol'] =  $_SESSION['descripcion_rol'];
           $Repuesta['id_sistema'] =  $_SESSION['id_sistema'];
           $Repuesta['sistema'] =  $_SESSION['sistema'];
           $Repuesta['alias'] =  $_SESSION['alias'];
           $Repuesta['url_declaracion'] =  $_SESSION['url_declaracion'];
           $Repuesta['IdPadreSistema'] =  $_SESSION['IdPadreSistema'];

           echo json_encode($Repuesta);
        break;


        case "password":
            $usuario->update_usuario_pass($_POST["usu_id"],$_POST["usu_pass"]);
        break; 

        case "accesogoogle":
            $datos = $usuario->get_usuario_x_correo($_POST["usu_correo"]);
            if(count($datos)==0){
                echo "0";
            }else{
                $_SESSION["usu_id"]=$datos[0]["usu_id"];
                $_SESSION["usu_nom"]=$datos[0]["usu_nom"];
                $_SESSION["usu_ape"]=$datos[0]["usu_ape"];
                $_SESSION["rol_id"]=$datos[0]["rol_id"];
                echo "1";
            }
            break;

    }  
?>