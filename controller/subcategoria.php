<?php
    require_once("../config/conexion.php");
    require_once("../models/Subcategoria.php");
    $subcategoria = new Subcategoria();
    $html = "";

    switch($_GET["op"]){
        case "combo":
            $datos = $subcategoria->get_subcategoria($_POST["cat_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['cats_id']."'>".$row['cats_nom']."</option>";
                }
                echo $html;
            }    
        break;
    }
?>