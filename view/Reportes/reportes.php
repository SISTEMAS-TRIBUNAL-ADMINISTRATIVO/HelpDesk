<?php
require_once("../../config/conexion.php");
require_once("../../libs/dompdf/autoload.inc.php"); 

use Dompdf\Dompdf;
use Dompdf\Options;



$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);  
$dompdf = new Dompdf($options);


function loadBase64Image($path) {
    return base64_encode(file_get_contents($path));
}

$imageHeaderData = loadBase64Image("../../public/img/Encabezado2025.png");
$imageFooterData = loadBase64Image("../../public/img/pie-de-pagina.png");


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
<body>
    <!-- Encabezado -->
    <div class="header">
        <img src="data:image/png;base64,<?php echo $imageHeaderData; ?>" alt="Encabezado">
    </div>

    <div class="caption">
        <p>Aquí debe llevar una variable para la leyenda del año vigente: </p>
    </div>

    <div class="title">
        <h2>ACUSE DE SERVICIO</h2>
    </div>

    <div class="table-container">
        <table>

            <tr>
                <td style="vertical-align: top; padding-top: 10px;">
                    <div style="float: left; width: 50%; text-align: left;">
                        <strong>Folio:</strong> [Aquí va el Folio] <br>
                        <strong>Área requirente:</strong> [Aquí va el Área requirente]
                    </div>
                    <div style="float: right; width: 32%; text-align: left;">
                        <strong>Fecha:</strong> 20 de enero 2025 <br>
                        <strong>Hora:</strong> 11:16 am
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
                        <strong>Tipo de servicio:</strong> [Aquí va el tipo de servicio]
                    </div>
                    <div style="float: right; width: 32%; text-align: left;">
                        <strong>¿Se da solucion?</strong> Si <br>
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
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Porro architecto facere
                    ipsa dignissimos officiis eos in distinctio repellat aliquid velit nostrum sequi 
                    vitae esse, necessitatibus accusantium quae error qui doloribus?
                </td>
                <td>
                    <strong>Diagnóstico:</strong> <br>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam quaerat 
                    veritatis excepturi fugit saepe consequatur perferendis, harum ullam rerum 
                    praesentium reprehenderit nesciunt nihil minima atque eius earum. Officiis, 
                    consectetur esse.
                </td>
            </tr>
        </table>
    </div>


    <div class="table-container">
        <table>   
            <tr>
            <td style="vertical-align: top; padding-top: 10px;">
                    <div style="text-align: left;">
                        <strong>Observaciones: </strong> Lorem ipsum dolor sit amet, consectetur 
                        adipisicing elit. Numquam quaerat veritatis excepturi fugit saepe consequatur
                        perferendis, harum ullam rerum praesentium reprehenderit nesciunt nihil minima 
                        atque eius earum. Officiis, consectetur esse. <br>
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
                <td><span class="signature-line"></span><br>Nombre y firma <br><strong>[Cargo]</strong></td>
                <td><span class="signature-line"></span><br>Nombre y firma <br><strong>[Cargo]</strong></td>
                <td><span class="signature-line"></span><br>Nombre y firma <br><strong>[Cargo]</strong></td>
            </tr>
        </table>
    </div>
    

    <!-- Pie de página -->
    <div class="footer">
        <img src="data:image/png;base64,<?php echo $imageFooterData; ?>" alt="Pie de página">
    </div>

</body>
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
