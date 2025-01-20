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
    $imgPath = "../../public/img/Encabezado2025.png";
    
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


            /* Div vacío para simular el espacio antes de la tabla */
            .space {
                height: 10mm; 
            }


            /* Estilos de la tabla */
            .table-container {
                width: 100%;
                margin-top: 15mm;
                display: flex;
                justify-content: center;
            }
            table {
                width: 90%; /* Asegura que no ocupe todo el ancho */
                margin: auto;
            }
            th, td {
                border: 1px solid #000;
                padding: 10px;
                text-align: center;
                font-size: 12pt;
            }
        </style>

        


    </head>
    <body>
        <!-- Encabezado -->
        <div class="header">
        <img src="data:image/png;base64,<?php echo $imageData; ?>" alt="Encabezado">
        </div>

        <!-- Espacio vacío de 100mm (10 cm) antes de la tabla -->
        <div class="space"></div>

        <div class="table-container">
            <table>
                <tr>
                    <td style="vertical-align: top; padding-top: 10px;">
                        <div style="float: left; width: 50%; text-align: left;">
                            <strong>Folio:</strong> [Aquí va el Folio] <br>
                            <strong>Área requirente:</strong> [Aquí va el Área requirente]
                        </div>
                        <div style="float: right; width: 30%; text-align: left;">
                            <strong>Fecha:</strong> 20 de enero 2025 <br>
                            <strong>Hora:</strong> 11:16 am
                        </div>
                        <div style="clear: both;"></div> <!-- Limpia los floats -->
                    </td>
                </tr>
                
                <tr>
                    <td style="height: 1px; border: none;"></td> <!-- Espacio vacío con una altura mínima -->
                </tr>

                <tr>
                <td style="vertical-align: top; padding-top: 10px;">
                        <div style="text-align: left;">
                            <strong>Tipo de servicio: </strong> [Aquí va el tipo de servicio] <br>
                        </div>
                    </td>
                </tr>
            </table>          
        </div>

        <div class="table-container">
            <table>
                <tr>
                    <td style="vertical-align: top; padding-top: 10px; width:50%;">Descripcion del problema</td>
                    <td style="vertical-align: top; padding-top: 10px;">Diagnostico</td>
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
