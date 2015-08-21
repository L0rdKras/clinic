<?php

if(confirma_datos_arreglo($_GET,array("dia","id_disponible")))
{
	extract($_GET);

	$busca = new Consulta("SELECT * FROM shedule WHERE consultation_date='$dia' AND disponibles_time_id='$id_disponible'");

	if($busca->filas_resultado()==0)
	{
		require "../librerias/registro_horas/vistas/buscar_paciente.php";
	}

}

?>