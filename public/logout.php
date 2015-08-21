<?php
session_start();

if(file_exists("../Controller/master.php")){

	$nombre_pagina	=	"logout";
	$plantilla		=	"normal";
	$titulo 		=	"Desconectar";
	require "../Controller/master.php";

	if(sesion_activa())
	{
		$_SESSION['nick'] = "";
		$_SESSION['nombre'] = "";
		$_SESSION['permiso'] = "GUEST";

		header('Location: /');
	}else{
		
		crear_ventana($nombre_pagina,$plantilla,compact('titulo'));
	}


}else{
	die("Controlador no encontrado");
}