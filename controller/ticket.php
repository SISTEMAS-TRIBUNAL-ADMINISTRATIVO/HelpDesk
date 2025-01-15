<?php
    require_once("../config/conexion.php");
    require_once("../models/ticket.php");
    $ticket = new Ticket();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    require_once("../models/Documento.php");
    $documento = new Documento();

    switch($_GET["op"])
    {

        case "insert":
            $usu_id = $_SESSION["Enlace"];
            $cat_id = $_POST["cat_id"];
            $cats_id = $_POST["cats_id"];
            $tick_titulo = $_POST["tick_titulo"];
            $tick_descrip = $_POST["tick_descrip"];
            $datos = $ticket->insert_ticket($usu_id, $cat_id, $cats_id, $tick_titulo, $tick_descrip);

            if (is_array($datos)==true and count($datos)>0)
            {
                foreach ($datos as $row)
                {
                    $output["Id"] = $row["Id"];

                    if (isset($_FILES['files']) && $_FILES['files']['error'] == 0)
                    {

                        $countfiles = count($_FILES['files']['name']);
                        $ruta = "../public/document/".$output["Id"]."/";
                        $files_arr = array();

                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES['files']['tmp_name'][$index];
                            $destino = $ruta.$_FILES['files']['name'][$index];

                            $documento->insert_documento( $output["Id"],$_FILES['files']['name'][$index]);

                            move_uploaded_file($doc1,$destino);
                        }
                    }
                }
            }
            echo json_encode($datos);
           
        break;

        case "update":
            $ticket->update_ticket($_POST["tick_id"]);
            $ticket->insert_ticketdetalle_cerrar($_POST["tick_id"],$_POST["usu_id"]);
        break;

        case "reabrir":
            $ticket->reabrir_ticket($_POST["tick_id"]);
            $ticket->insert_ticketdetalle_reabrir($_POST["tick_id"],$_POST["usu_id"]);
        break;

        case "asignar":
            $ticket->update_ticket_asignacion($_POST["tick_id"],$_POST["usu_asig"], $_SESSION['Enlace']);
        break;

        case "listar_x_usu":
            $datos= $ticket->listar_ticket_x_usu($_POST["usu_id"]);
            $data= array();
            foreach($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];


                if($row["descrip_estatus"]=="Activo") 
                {
                    $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
                }else
                {
                    $sub_array[] = '<a><span class="label label-pill label-danger">Cerrado</span><a>';
                }


                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                if($row["fech_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["nombre"].'</span>';
                    }
                } 

                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listar":
            $datos= $ticket->listar_ticket();
            $data= array();

            foreach($datos as $row) 
            {
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                if($row["descrip_estatus"]=="Activo") 
                {
                    $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
                }else
                {
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">Cerrado</span><a>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));


                if($row["fech_asig"]==null)
                {
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["usu_asig"]==null)
                {
                    $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
                }else
                {
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);

                    foreach($datos1 as $row1)
                    {
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["nombre"].'</span>';
                    }
                }
                
                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                

                $data[] = $sub_array;
            }
                $results = array(
                    "sEcho"=>1,
                    "iTotalRecords"=>count($data),
                    "iTotalDisplayRecords"=>count($data),
                    "aaData"=>$data);
                echo json_encode($results);
           
        break;

        case "listar_filtro":
            $datos=$ticket->filtrar_ticket($_POST["cat_id"]);

            $data= Array();
            foreach($datos as $row)
            {
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                if ($row["descrip_estatus"]=="Activo")
                { 
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else
                {
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">Cerrado</span><a>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

                if($row["fech_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }


                if($row["usu_asig"]==null){
                    $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["nombre"].'</span>';
                    }
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';

                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;
            
        case"listardetalle":
                $datos= $ticket->listar_ticketdetalle_x_ticket($_POST["tick_id"]);
                ?>
                    <?php
                        foreach($datos as $row)
                        {
                            ?>
                                <article class="activity-line-item box-typical">
                                    <div class="activity-line-date">
                                        <?php echo date("d/m/Y", strtotime($row["fech_crea"]));?>
                                    </div>

                                    <?php $datos1=$usuario->get_usuario_x_id($row["usu_id"]);

                                        foreach($datos1 as $row2)
                                        {?>
                                            <header class="activity-line-item-header">
                                                <div class="activity-line-item-user">
                                                    <div class="activity-line-item-user-photo">
                                                        <a href="#">
                                                            <img src="../../public/img/1.jpg echo $row2['id_rol'] ?>.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="activity-line-item-user-name"><?php echo $row2['nombre'].' '.$row2['paterno'];?></div>
                                                    <div class="activity-line-item-user-status">
                                                        <?php 
                                                            if ($row2['id_rol']==4)
                                                            {
                                                                echo 'Usuario';
                                                            }else
                                                            {
                                                                echo 'administrador';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </header>
                                        <?php
                                        }
                                        ?>
                                    
                                    <div class="activity-line-action-list">
                                        <section class="activity-line-action">
                                            <div class="time"><?php echo date("H:i:s", strtotime($row["fech_crea"]));?></div>
                                            <div class="cont">
                                                <div class="cont-in">
                                                    <p>
                                                        <?php echo $row["tickd_descrip"];?>
                                                    </p>

                                                <?php
                                                    $datos_det=$documento->get_documento_detalle_x_ticketd($row["tickd_id"]);
                                                    if(is_array($datos_det)==true and count($datos_det)>0){
                                                        ?>
                                                            <p><strong>Documentos Adicionales</strong></p>

                                                            <p>
                                                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 60%;"> Nombre</th>
                                                                        <th style="width: 40%;"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                        <?php
                                                                            foreach ($datos_det as $row_det){ 
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $row_det["det_nom"]; ?></td>
                                                                                <td>
                                                                                    <a href="../../public/document_detalle/<?php echo $row_det["tickd_id"]; ?>/<?php echo $row_det["det_nom"]; ?>" target="_blank" class="btn btn-inline btn-primary btn-sm">Ver</a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                </tbody>
                                                            </table>

                                                            </p>
                                                        <?php
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </article>
                            <?php
                        }
                    ?>
                <?php
        break;

        case "mostrar";
            $datos=$ticket->listar_ticket_x_id($_POST["tick_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tick_id"] = $row["tick_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["cat_id"] = $row["cat_id"];

                    $output["tick_titulo"] = $row["tick_titulo"];
                    $output["tick_descrip"] = $row["tick_descrip"];

                    $output["descrip_estatus"] = $row["descrip_estatus"];
                    
                    if($row["descrip_estatus"]=="Activo"){
                        $output["lblestado"] = '<span class="label label-pill label-success">Activo</span>';
                    }else{
                        $output["lblestado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $output["fech_crea"] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    $output["nombre"] = $row["nombre"];
                    $output["paterno"] = $row["paterno"];
                    $output["cat_nom"] = $row["cat_nom"];
                    $output["cats_nom"] = $row["cats_nom"]; 
                    $output["tick_estre"] = $row["tick_estre"];
                    $output["tick_coment"] = $row["tick_coment"];
                }
                echo json_encode($output); 
            
            }   
        break;

        case "insertdetalle":
            $datos=$ticket->insert_ticketdetalle($_POST["tick_id"],$_POST["tickd_descrip"], $_SESSION['id_rol'], $_SESSION['Enlace']);
            if (is_array($datos)==true and count($datos)>0){
                foreach ($datos as $row){
                    /* TODO: Obtener tikd_id de $datos */
                    $output["tickd_id"] = $row["tickd_id"];
                    /* TODO: Consultamos si vienen archivos desde la vista */
                    if (empty($_FILES['files']['name'])){

                    }else{
                        /* TODO:Contar registros */
                        $countfiles = count($_FILES['files']['name']);
                        /* TODO:Ruta de los documentos */
                        $ruta = "../public/document_detalle/".$output["tickd_id"]."/";
                        /* TODO: Array de archivos */
                        $files_arr = array();
                        /* TODO: Consultar si la ruta existe en caso no exista la creamos */
                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        /* TODO:recorrer todos los registros */
                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES['files']['tmp_name'][$index];
                            $destino = $ruta.$_FILES['files']['name'][$index];

                            $documento->insert_documento_detalle($output["tickd_id"],$_FILES['files']['name'][$index]);

                            move_uploaded_file($doc1,$destino);
                        }
                    }
                }
            }
            echo json_encode($datos);
        break;

        case "total";
            $datos=$ticket->get_ticket_total();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalabierto";
            $datos=$ticket->get_ticket_totalabierto();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalcerrado";
            $datos=$ticket->get_ticket_totalcerrado();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "grafico";
            $datos=$ticket->get_ticket_grafico();  
            echo json_encode($datos);
        break;

        case "encuesta":
            $ticket->insert_encuesta($_POST["tick_id"],$_POST["tick_estre"],$_POST["tick_coment"]);
        break;

        case "all_calendar":

            if($_SESSION['id_rol'] == 3)
            {
                $datos=$ticket->get_calendar_all();
            }
            else
            {
                $datos=$ticket->get_calendar_usu($_SESSION['Enlace']);
            }

            echo json_encode($datos);
        break;

        case "EstadoTicket";
            $datos=$ticket->EstadoTicket($_POST["tick_id"]); 

            if(is_array($datos)==true and count($datos)>0)
            {
                foreach($datos as $row)
                {
                    $output["usu_asig"] = $row["usu_asig"];
                    $output["tick_id"] = $_POST["tick_id"];
                }
                echo json_encode($output); 
            }   
        break;
    }
?>