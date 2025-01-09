<?php
  require_once("../config/conexion.php"); 
  $conexion = new Conectar();


  switch($_GET["op"])
  {
    case "HelpDesk";
    {
            $output["Url_HelpDesk"] = $conexion->rutaHelpdesk();
            echo json_encode($output); 
    }   
    break;

    case "PortalTA";
    {
            $output["Url_PortalTA"] = $conexion->rutaPortal();
            echo json_encode($output); 
    }   
    break;
 }
?>