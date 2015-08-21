<?php

if(isset($_GET['tabla']) && !empty($_GET['tabla']))
{
	//
	$nombre_tabla = $_GET['tabla'];

	$busca = new Consulta("SELECT * from $nombre_tabla");

	if($busca->filas_resultado()>0)
	{
		echo "NO";
	}else{
		echo "SI";
	}
}