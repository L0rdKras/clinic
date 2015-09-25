<?php
session_start();

if(file_exists("../Controller/master.php")){
	
	$nombre_pagina	=	"index";
	$plantilla		=	"normal";
	$titulo 		=	"Clinica Dental";
	require "../Controller/master.php";
	//$prueba 		=	new Consulta("SELECT * from usuarios");
	$opciones 		=	array(
		"Registrar Paciente"=>"/crear_paciente.php",
		"Registrar Empresa"=>"/crear_empresa.php",
		"Reserva Horas"=>"/registro_horas.php"
	);
	crear_ventana($nombre_pagina,$plantilla,compact('titulo','opciones'));

}else{
	
	die("Controlador no encontrado");
	
}