<?php

if(confirma_datos_arreglo($_POST,array("id")))
{
	extract($_POST);

	$ejecutor = new EjecutarSql();

	if($ejecutor->ejecutar("DELETE FROM shedule WHERE id='$id'"))
	{
		echo "Borro";
	}else{
		echo "Problema al borrar";
	}
}else{
	echo "Sin Datos";
}