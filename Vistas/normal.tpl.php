<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?= $titulo?></title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/base.css" media="screen" type="text/css">
	<link rel="stylesheet" href="css/normalize.css" media="screen" type="text/css">
</head>
<body>
	<header>
		<h1><a href="index.php">Sistema Clinica</a></h1>
		<?php
		if($estado_sesion)
		{
			?>
			<div class="sesion">
				<!--<input type="button" value="logout" onclick="funciones_logout()" id="btn_desconectar">-->
				<button class="boton_salir" onclick="funciones_logout()" id="btn_desconectar">Salir</button>
			</div>
			<?php
		}

		?>
	</header>
	<div id="contenedor">
		<?= $contenido_web?>
	</div>
	<footer>
		Sistema 2015
	</footer>
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="js/vrut.js"></script>
	<script type="text/javascript" src="js/utilidades.js"></script>
	<script type="text/javascript" src="js/clinica.js"></script>
	<script type="text/javascript" src="js/validacampo.js"></script>
	<script type="text/javascript" src="js/jquery.simplemodal.1.4.4.min.js"></script>
	<script type="text/javascript" src="js/crear_paciente.js"></script>
	<script type="text/javascript" src="js/crear_empresa.js"></script>
	<script type="text/javascript" src="js/registro_horas.js"></script>

	<!--calendario-->
	<link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
	<script type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<!--calendario--> 	
</body>
</html>