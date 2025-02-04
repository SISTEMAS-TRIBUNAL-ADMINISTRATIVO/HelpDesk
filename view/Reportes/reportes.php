<?php
require_once("../../config/conexion.php");
require_once("../../libs/dompdf/autoload.inc.php"); 
require_once("../../models/reporte.php");
$reporte = new Reporte();
$Leyenda;


use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);  
$dompdf = new Dompdf($options);

function loadBase64Image($path) 
{
    return base64_encode(file_get_contents($path));
}


$datosGenerales = $reporte->get_general_reporte();

foreach($datosGenerales as $ResultadoGeneral)
{
    $imageHeaderData = loadBase64Image('data:image/jpeg;base64,' . base64_encode($ResultadoGeneral["encabezado"]));
    $imageFooterData = loadBase64Image('data:image/jpeg;base64,' . base64_encode($ResultadoGeneral["pie_pagina"]));
    $Leyenda = $ResultadoGeneral["leyenda"];
}

//$imageHeaderData = loadBase64Image("../../public/img/Encabezado2025.png");
//$imageFooterData = loadBase64Image("../../public/img/pie-de-pagina.png");

ob_start();  // Iniciar captura del contenido HTML

?>

<!DOCTYPE html>
<html>
<head>
    <title>Acuse de Servicio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0; 
            padding: 0;
            width: 100%;
            height: 100%;
        }
        .header, .footer {
            width: 100%;
            text-align: center;
        }
        .header img, .footer img {
            width: 100%;
            height: auto;
        }
        .content {
            margin: 20mm;
        }

        .caption p {
            text-align: center;
            font-size: 10pt;
            color: blue;
            font-style: italic;
            margin-top: 5px;
        }

        .title h2 {
            text-align: center;   
            font-size: 11pt;  
            font-weight: bold;    
            text-decoration: underline; 
            margin-top: 0;      

        }



        /* Estilos de la tabla */
        .table-container {
            width: 100%;
            margin-top: 5mm;
            display: flex;
            justify-content: center;
        }
        table {
            width: 90%; 
            margin: auto;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: justify;
            font-size: 10pt;
        }


        .signatures {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .signatures table {
            width: 100%;
            border-collapse: collapse;
        }
        .signatures td {
            vertical-align: top;
            padding: 40px;
            text-align: center;
            border: none; 
        }

        .signature-line {
            display: block; 
            width: 100%; 
            border-top: 1px solid black; 
            margin-bottom: 5px; 
        }
    </style>

    

</head>

<?php
    $reporte-> get_setear_fecha();
    $DatosTick = $reporte-> get_reporte_ticket(1);
    
    foreach($DatosTick as $ReporteTick)
    {
    ?>
        <body>
        <!-- Encabezado -->
        <div class="header">
            <img src="data:image/png;base64,<?php echo $imageHeaderData; ?>" alt="Encabezado">
        </div>
    
        <div class="caption">
            <p> <?php echo $Leyenda ?> </p>
        </div>
    
        <div class="title">
            <h2>ACUSE DE SERVICIO</h2>
        </div>
    
        <div class="table-container">
            <table>
    
                <tr>
                    <td style="vertical-align: top; padding-top: 10px;">
                        <div style="float: left; width: 50%; text-align: left;">
                            <strong>Folio:</strong> <?php echo $ReporteTick["cat_id"] ?> <br>
                            <strong>Área requirente:</strong> <?php echo $ReporteTick["area_crea"] ?>
                        </div>
                        <div style="float: right; width: 32%; text-align: left;">
                            <strong>Fecha:</strong> <?php echo $ReporteTick["fecha_crea"] ?> <br>
                            <strong>Hora:</strong> <?php echo $ReporteTick["hora"] ?>
                        </div>
                        <div style="clear: both;"></div> 
                    </td>
                </tr>
                
                <tr>
                    <td style="height: 1px; border: none;"></td>
                </tr>
    
    
                <tr>
                    <td style="vertical-align: top; padding-top: 10px;">
                        <div style="float: left; width: 50%; text-align: left;">
                            <strong>Tipo de servicio:</strong> <?php echo $ReporteTick["cat_nom"] ?>
                        </div>
                        <div style="float: right; width: 32%; text-align: left;">
                            <strong>¿Se da solucion?</strong> <?php echo $ReporteTick["se_da_solucion"] ?> <br>
                        </div>
                        <div style="clear: both;"></div> 
                    </td>
                </tr>
                
            </table>          
        </div>
    
    
        <div class="table-container">
            <table>
                <tr>
                    <td>
                        <strong>Descripción del problema:</strong> <br>
                        <?php echo $ReporteTick["tick_descrip"] ?>
                    </td>
                    <td>
                        <strong>Diagnóstico:</strong> <br>
                        <?php echo $ReporteTick["diagnostico"] ?>
                    </td>
                </tr>
            </table>
        </div>
    
    
        <div class="table-container">
            <table>   
                <tr>
                <td style="vertical-align: top; padding-top: 10px;">
                        <div style="text-align: left;">
                            <strong>Observaciones: </strong> 
                            <?php echo $ReporteTick["observaciones"] ?>
                            <br>
                        </div>
                    </td>
                </tr>
            </table>          
        </div>
    
        <!-- Firmas -->
        <div class="signatures">
            <table style="width: 100%; text-align: center; border-collapse: collapse;">
                <tr>
                    <td style="height: 10%; border: none;"></td> 
                </tr>
                <!-- Fila de títulos -->
                <tr>
                    <td>Realizó</td>
                    <td>Validó</td>
                    <td>De conformidad</td>
                </tr>
                <!-- Fila de líneas y nombres -->
                <tr>
                    <td><span class="signature-line"></span><br> <?php echo $ReporteTick["nombre_realizo"] ?> <br><strong> <?php echo $ReporteTick["cargo_realizo"] ?> </strong></td>
                    <td><span class="signature-line"></span><br> <?php echo $ReporteTick["nombre_valido"] ?> <br><strong> <?php echo $ReporteTick["cargo_valido"] ?> </strong></td>
                    <td><span class="signature-line"></span><br> <?php echo $ReporteTick["nombre_conformidad"] ?> <br><strong> <?php echo $ReporteTick["cargo_conformidad"] ?> </strong></td>
                </tr>
            </table>
        </div>
        
    
        <!-- Pie de página -->
        <div class="footer">
            <img src="data:image/png;base64,<?php echo $imageFooterData; ?>" alt="Pie de página">
        </div>
    
    </body>
    <?php
    }
?>

</html>

<?php

$html = ob_get_clean();  // Obtener el contenido HTML capturado

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->getCanvas()->page_script(function ($canvas) {
    // Asegurándonos de usar centímetros
    $canvas->get_cpdf()->setMargins(30, 25, 25, 30); 
});
// Renderizar el PDF
$dompdf->render();

// Enviar el PDF al navegador
$dompdf->stream("Acuse Servicio.pdf", array("Attachment" => 0));  

?>
