<?php

if(file_exists("../Controller/master.php")){

	require "../Controller/master.php";

	$usuario = new Usuario();

	$data = array(
		"nick" => "admin",
		"nombre" => "Admin",
		"clave" => "claveAdmin",
		"cargo" => "Admin",
		"email" => "admin@admin.cl",
		"estado" => "1"
		);

	if($usuario->crear($data))
	{ 
		echo "usuario admin creado";
	}else{
		echo "sucedio algun error";
	}

}else{
	die("Controlador no encontrado");
}

?>