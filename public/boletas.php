<?php
session_start();

if(file_exists("../Controller/master.php")){

	$hoy 			= date("Y-m-d");

	$nombre_pagina	=	"boletas";
	$plantilla		=	"normal";
	$titulo 		=	"Registro Boleta";
	require "../Controller/master.php";

	crear_ventana($nombre_pagina,$plantilla,compact('titulo'));
	
}else{
	die("Controlador no encontrado");
}