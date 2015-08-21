<?php

if(isset($_GET['dato']) && !empty($_GET['dato']) && isset($_GET['tabla']) && !empty($_GET['tabla']) && isset($_GET['campo']) && !empty($_GET['campo']))
{
	//
	extract($_GET);

	$busca = new Consulta("SELECT * from $tabla where $campo='$dato'");
	if($busca->filas_resultado()>0){
		//
		$envia ="";

		$arreglo = $busca->resultado_arreglo();

		$arreglo_respuesta = $arreglo[0];

		$arreglo_respuesta["respuesta"] = "Exito";

		echo formato_json($arreglo_respuesta);
	}else{
		echo formato_json(array("respuesta"=>"Error"));
	}

}else{
	//
	echo "Error";
}