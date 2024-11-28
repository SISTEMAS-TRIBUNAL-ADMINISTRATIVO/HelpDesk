<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["Enlace"])){ 
?> 
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<link rel="stylesheet" href="../../public/css/lib/fullcalendar/fullcalendar.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/calendar.min.css">

	<link rel="stylesheet" href="../../public/css/lib/bootstrap-sweetalert/sweetalert.css">
    <link rel="stylesheet" href="../../public/css/separate/vendor/sweet-alert-animations.min.css">
	<title>TAPJE | Soporte</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>
    
    <?php require_once("../MainNav/nav.php");?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12">
					<div class="row">
						<div class="col-sm-4">
	                        <article class="statistic-box green">
	                            <div>
	                                <div class="number" id="lbltotal" name="lbltotal"></div>
	                                <div class="caption"><div>Total de Tickets</div></div>
	                            </div>
	                        </article>
	                    </div>
						<div class="col-sm-4">
	                        <article class="statistic-box yellow">
	                            <div>
	                                <div class="number" id="lbltotalabierto" name="lbltotalabierto"></div>
	                                <div class="caption"><div>Total de Tickets Abiertos</div></div>
	                            </div>
	                        </article>
	                    </div>
						<div class="col-sm-4">
	                        <article class="statistic-box red">
	                            <div>
	                                <div class="number" id="lbltotalcerrado" name="lbltotalcerrado"></div>
	                                <div class="caption"><div>Total de Tickets Cerrados</div></div>
	                            </div>
	                        </article>
	                    </div>
					</div>
				</div>
			</div>

			<section class="card">
				<header class="card-header">
					Grafico Estadístico
				</header>
				<div class="card-block">
					<div id="divgrafico" style="height: 250px;"></div>
				</div>
			</section>

			<section class="card">
				<header class="card-header">
					Calendario
				</header>
				<div class="card-block">
					<div id="idcalendar"></div>
				</div>
			</section>
			
		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>

	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

	<script type="text/javascript" src="../../public/js/lib/moment/moment-with-locales.min.js"></script>
	<script src="../../public/js/lib/fullcalendar/fullcalendar.min.js"></script>
	
	<!-- TODO: Liberia SweetAlert -->
<script src="../../public/js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>
<script src="../../public/js/lib/match-height/jquery.matchHeight.min.js" type="text/javascript" ></script>

	<script type="text/javascript" src="home.js"></script>
	<script type="text/javascript" src="../notificacion.js"></script>


</body>
</html>
<?php
  } else { 
   $conectar = new Conectar(); // Instancia un objeto de la clase Conectar
   header("Location: " . $conectar->ruta() . "../index.php"); // Llama a ruta() en el objeto instanciado
}
?>