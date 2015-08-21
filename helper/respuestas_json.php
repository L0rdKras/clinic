<?php

function formato_json($datos = array())
{
	$json 				= new stdClass();
	/*$json->respuesta 	= $resolucion;
	$json->mensaje 		= $mensaje;*/

	foreach ($datos as $key => $value) {
		# code...
		$json->$key = $value;
	}

	$responde 		= json_encode($json);

	return $responde;
}