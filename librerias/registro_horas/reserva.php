<?php

if(confirma_datos_arreglo($_POST,array("atencion","dia","horario","paciente")))
{
	extract($_POST);

	$ejecutor = new EjecutarSql();

	if($ejecutor->ejecutar("INSERT INTO shedule(consultation_date,disponibles_time_id,patient_id,atention_id,medic_id,confirm) values('$dia','$horario','$paciente','$atencion','1','0')"))
	{
		if(isset($segundo_bloque))
		{
			if($segundo_bloque>0)
			{
				$ejecutor->ejecutar("INSERT INTO shedule(consultation_date,disponibles_time_id,patient_id,atention_id,medic_id,confirm) values('$dia','$segundo_bloque','$paciente','$atencion','1','0')");
			}
		}
		die("Guardo");
	}else{
		die("Problema al Guardar");
	}

}else{
	die("Faltan Datos");
}

?>