<?php
session_start();

if(file_exists("../Controller/master.php")){

	$hoy 			= date("Y-m-d");

	$nombre_pagina	=	"crear_paciente";
	$plantilla		=	"normal";
	$titulo 		=	"Registro Pacientes";
	require "../Controller/master.php";

	$busca_empresas = new Consulta("SELECT * FROM companies order by name");

	if($busca_empresas->filas_resultado()>0)
	{
		$lista_empresas = $busca_empresas->resultado_arreglo();
		crear_ventana($nombre_pagina,$plantilla,compact('titulo','lista_empresas'));
	}else{
		die("Problemas al cargar empresas");
	}
}else{
	die("Controlador no encontrado");
}