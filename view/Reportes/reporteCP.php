<?php
require_once("../../config/conexion.php");
require_once("../../libs/dompdf/autoload.inc.php");  // Incluir dompdf

use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_SESSION["Enlace"])) {

    // Crear una instancia de Dompdf
    $dompdf = new Dompdf();
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);  // Habilitar funciones PHP
    $dompdf->setOptions($options);

    ob_start();  // Iniciar captura del contenido HTML

    // Ruta de la imagen
    $imgPath = "../../public/img/Encabezado.png";
    
    // Verificar si la imagen se carga correctamente
    $imageData = file_get_contents($imgPath);
    if ($imageData === false) {
        echo "Error al leer la imagen.";
        exit;
    }
    $imageData = base64_encode($imageData);  // Codificar imagen a base64

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>PDF Vacío</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0; 
                padding: 0;
                width: 100%;
                height: 100%;
            }
            .header {
                width: 100%;
                text-align: center;
                position: relative;
            }
            .header img {
                width: 100%;  /* Ocupar todo el ancho de la página */
                height: auto;  /* Mantener proporción */
            }
            .content {
                margin: 20mm; /* Márgenes estándar para el contenido del documento */
            }



            .info {
                width: 100%;
                position: relative;
                margin-top: 5mm; 
                font-size: 12pt;
                font-weight: bold;
            }

            .left{
                position: absolute;
                leftt: 0;
                padding-left: 10mm;
            }

            .right {
                text-align: right;
                margin-right: 20mm;
            }



            .table-container {
            width: 100%;
            margin-top: 30mm;
            display: flex;
            justify-content: center;
            }
            table {
                width: 90%;
                border-collapse: collapse;
                border: 2px solid black;
            }
            th, td {
                border: 2px solid black;
                padding: 10px;
                text-align: center;
                font-size: 12pt;
            }
            .sub-table {
                width: 100%;
                border-collapse: collapse;
            }
            .sub-table td {
                border: 1px solid black;
                text-align: center;
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <!-- Encabezado -->
        <div class="header">
        <img src="data:image/png;base64,<?php echo $imageData; ?>" alt="Encabezado">
        </div>


        <!-- Información del documento -->
        <div class="info">
            <div class="left">Folio: HS-AI:002/2025</div>
            <div class="right">
                Fecha: 15/01/2025 <br>
                Hora: HR
            </div>
        </div>
        
        <!-- Tabla -->
        <div class="table-container">
            <table>
                <tr>
                    <td><strong>Tipo de servicio</strong></td>
                </tr>
                <tr>
                    <td><strong>Descripción del problema o solicitud</strong></td>
                </tr>
                <tr>
                    <td><strong>Diagnóstico</strong></td>
                    <td colspan="2">
                        <strong>¿Se da solución?</strong>
                        <table class="sub-table">
                            <tr>
                                <td>Sí</td>
                                <td></td>
                                <td>No</td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        
    </body>
    </html>

    <?php

    $html = ob_get_clean();  // Obtener el contenido HTML capturado

    // Cargar el contenido HTML en dompdf
    $dompdf->loadHtml($html);

    // (Opcional) Configurar el tamaño de la página
    $dompdf->setPaper('A4', 'portrait');

    // Renderizar el PDF
    $dompdf->render();

    // Enviar el PDF al navegador
    $dompdf->stream("pdf_vacio.pdf", array("Attachment" => 0));  // 0 = Mostrar en el navegador

} else {
    $conexion = new Conectar(); // Crear una instancia de la clase Conectar
    header("Location:" . $conexion->rutaHelpdesk() . "index.php");
}
?>
