<?php
session_start();

if(file_exists("../Controller/master.php")){

	$hoy 			= date("Y-m-d");

	$nombre_pagina	=	"registro_horas";
	$plantilla		=	"normal";
	$titulo 		=	"Registro Horas";
	require "../Controller/master.php";

	crear_ventana($nombre_pagina,$plantilla,compact('titulo','hoy'));

}else{
	die("Controlador no encontrado");
}
?>