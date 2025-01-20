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
                font-family: 'Calibri', sans-serif;
                font-size: 12pt;
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

           /* Estilos para casillas de verificación */
            .checkbox {
                width: 20px;
                height: 20px;
            }




            .signatures {
                position: fixed; /* Fija la posición en el pie de página */
                bottom: 40mm;    /* Margen desde la parte inferior de la página */
                left: 0;
                width: 100%;
                text-align: center;
            }
            .signatures table {
                width: 90%; /* Asegura que no ocupe todo el ancho */
                margin: auto;
            }
            .signatures td {
                text-align: center;
                padding-top: 15mm;
                font-weight: bold;
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
        

        <!-- Espacio vacío de 100mm (10 cm) antes de la tabla -->
        <div class="space"></div>

        <!-- Tabla -->
        <div class="table-container">
            <table>

                <tr>
                    <td style="vertical-align: top; padding-top: 10px; height: 20%; width: 70%;">Tipo de servicio</td>
                    <td style="vertical-align: top; padding-top: 10px; width: 40%;">Trabajo realizado</td>
                </tr>

            </table>


            
        </div>

        <div class="table-container">
            <table>

                <tr>
                    <td style="vertical-align: top; padding-top: 10px; width: 50%; height: 20%;">Descripción del problema o solicitud</td>
                    <td style="width: 50%; height: 20%;"></td>
                </tr>

            </table>            
        </div>

        <div class="table-container">
            <table>

                <tr>
                    <td style="vertical-align: top; padding-top: 10px; width: 50%; height: 20%;">Diagnóstico</td>
                    <td style="width: 50%; height: 20%;"></td>
                </tr>

            </table>            
        </div>


        <div class="table-container">
            <table>

                <tr>
                    <td style="width: 50%;">¿Se da solución?</td>
                    <td style="width: 50%;">
                        <table class="sub-table">
                            <tr>
                                <td style="width: 50%;"><input type="checkbox" class="checkbox"> Sí</td>
                                <td style="width: 50%;"><input type="checkbox" class="checkbox"> No</td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>            
        </div>



        <!-- Firmas -->
        <div class="signatures">
            <table>
                <!-- Fila de títulos -->
                <tr>
                    <td style="vertical-align: top; padding-top: 10px;">
                        Realizo
                        <br></br>
                        <br></br>
                        <br></br>
                        <br></br>
                    </td>
                    <td style="vertical-align: top; padding-top: 10px;">
                        Valido
                    </td>
                    <td style="vertical-align: top; padding-top: 10px;">
                        De conformidad
                    </td>
                </tr>
                <!-- Fila de líneas para firma -->
                <tr>
                    <td style="border-top: 1px solid black; padding-top: 10px;">
                        Nombre y firma
                    </td>
                    <td style="border-top: 1px solid black; padding-top: 10px;">
                        Nombre y firma
                    </td>
                    <td style="border-top: 1px solid black; padding-top: 10px;">
                        Nombre y firma
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
