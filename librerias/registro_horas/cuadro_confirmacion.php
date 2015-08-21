<?php

if(confirma_datos_arreglo($_GET,array("atencion","dia","horario")))
{
	extract($_GET);

	$busca = new Consulta("SELECT * FROM atentions WHERE id='$atencion'");

	if($busca->filas_resultado()>0)
	{
		$data_atencion = $busca->resultado_arreglo();

		$id_second_block = 0;

		if($data_atencion[0]['blocks_number']==2)
		{
			//revisa si el siguiente bloque esta ocupado
			if($horario == 21){
				die("Esta atencion requiere 2 bloques para realizarse, no puede tomarse a esta hora");
			}else{
				$provisorio = $horario+1;

				$busca->cambiar_consulta("SELECT * FROM shedule WHERE consultation_date='$dia' AND disponibles_time_id='$provisorio'");
				if($busca->filas_resultado()==0){
					$id_second_block = $provisorio;
				}else{
					die("Esta atencion requiere 2 bloques para realizarse, no puede ser a esta hora porque el bloque siguiente esta tomado");
				}
			}
		}

		require "../librerias/registro_horas/vistas/confirmacion.php";
	}else{
		die("Atencion no identificada");
	}
}
?>