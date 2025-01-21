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

    // Ruta de la imagen del encabezado
    $imgHeaderPath = "../../public/img/Encabezado2025.png";
    $imageHeaderData = base64_encode(file_get_contents($imgHeaderPath));

    // Ruta de la imagen del pie de página
    $imgFooterPath = "../../public/img/pie-de-pagina.png";
    $imageFooterData = base64_encode(file_get_contents($imgFooterPath));

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>PDF Vacío</title>
        <style>
            body {
                font-family: Arial;
                font-size: 10pt;
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
                margin-top: 5mm;
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
                text-align: justify;
                font-size: 12pt;
            }




            .signatures {
                width: 100%;
                display: flex;
                justify-content: center;
            }
            .signatures table {
                width: 80%;
                border-collapse: collapse;
            }
            .signatures td {
                vertical-align: top;
                padding: 26px;
                text-align: center;
                border: none; /* Elimina cualquier borde */
            }

            .signature-line {
                display: block; /* Hace que el span actúe como un bloque */
                width: 100%; /* Abarca todo el ancho de la celda */
                border-top: 1px solid black; /* Línea negra en la parte superior */
                margin-bottom: 5px; /* Espaciado entre la línea y el texto */
            }



            .footer {
                position: fixed;
                bottom: 10mm;  /* Se ajusta 10mm por encima del borde de la hoja */
                left: 0;
                width: 100%;
                text-align: center;
                padding-bottom: 5mm; /* Margen extra si es necesario */
            }

            .footer img {
                width: 90%; /* Reducir un poco el tamaño para que no sobresalga */
                height: auto;
                margin: 0 auto; /* Centrar la imagen */
            }


        </style>

        


    </head>
    <body>
        <!-- Encabezado -->
        <div class="header">
        <img src="data:image/png;base64,<?php echo $imageHeaderData; ?>" alt="Encabezado">
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
                    <td style="height: 25%; border: none;"></td> <!-- Espacio vacío -->
                </tr>
                <!-- Fila de títulos -->
                <tr>
                    <td>Realizó</td>
                    <td>Validó</td>
                    <td>De conformidad</td>
                </tr>
                <!-- Fila de líneas y nombres -->
                <tr>
                    <td><span class="signature-line"></span><br>Nombre y firma</td>
                    <td><span class="signature-line"></span><br>Nombre y firma</td>
                    <td><span class="signature-line"></span><br>Nombre y firma</td>
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

    // Cargar el contenido HTML en dompdf
    $dompdf->loadHtml($html);

    // (Opcional) Configurar el tamaño de la página
    $dompdf->setPaper('A4', 'portrait');
    
    // Configurar los márgenes (izquierda, arriba, derecha, abajo)
    $dompdf->getCanvas()->page_script(function ($canvas) {
        $canvas->get_cpdf()->setMargins(2.5 * 28.35, 2.5 * 28.35, 2.5 * 28.35, 2.5 * 28.35);
    });

    // Renderizar el PDF
    $dompdf->render();

    // Enviar el PDF al navegador
    $dompdf->stream("pdf_vacio.pdf", array("Attachment" => 0));  // 0 = Mostrar en el navegador

} else {
    $conexion = new Conectar(); // Crear una instancia de la clase Conectar
    header("Location:" . $conexion->rutaHelpdesk() . "index.php");
}
?>
