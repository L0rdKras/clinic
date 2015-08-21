<?php

if(isset($_GET['dato']) && !empty($_GET['dato']) && isset($_GET['tabla']) && !empty($_GET['tabla']) && isset($_GET['campo']) && !empty($_GET['campo']) && isset($_GET['respuesta']) && !empty($_GET['respuesta']))
{
	//
	$tabla 		= $_GET['tabla'];
	$campo 		= $_GET['campo'];
	$dato 		= $_GET['dato'];
	$respuesta 	= $_GET['respuesta'];

	$busca = new Consulta("SELECT * from $tabla where $campo='$dato'");
	if($busca->filas_resultado()>0){
		//
		$envia ="";

		$arreglo = $busca->resultado_arreglo();

		foreach ($arreglo as $key => $value) {
			# code...
			$envia = $value[$respuesta];
		}

		echo $envia;
	}else{
		echo "Error";
	}

}else{
	//
	echo "Error";
}