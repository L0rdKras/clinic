<?php

if(confirma_datos_arreglo($_POST,array("id","estado")))
{
	extract($_POST);

	$ejecutor = new EjecutarSql();

	if($ejecutor->ejecutar("UPDATE shedule SET confirm = '$estado' WHERE id='$id'"))
	{
		echo "Guardo";
	}else{
		echo "Problema al guardar";
	}
}else{
	echo "Sin Datos";
}