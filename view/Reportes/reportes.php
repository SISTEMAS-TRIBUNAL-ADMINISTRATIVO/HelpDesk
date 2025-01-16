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
    $imgPath = "../../public/img/smile.png";
    
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
                margin: 20mm;
                height: 100%;
            }
            .header img {
                width: 150px;
                height: auto;  /* Cambiado de 100% a auto para mantener proporciones */
            }
        </style>
    </head>
    <body>
        <!-- Encabezado -->
        <div class="header">
        <img src="data:image/png;base64,<?php echo $imageData; ?>" alt="Logo">
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
