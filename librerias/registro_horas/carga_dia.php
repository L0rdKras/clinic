<?php

if(isset($_GET['dia']) && !empty($_GET['dia']))
{
	extract($_GET);
	$busca = new Consulta("SELECT * FROM (SELECT id as id_hd,initiation,final from disponibles_times order by id)t1 left join (SELECT * from shedule WHERE consultation_date = '$dia')t2 on t1.id_hd=t2.disponibles_time_id");

	$respuesta = $busca->resultado_arreglo();

	//$paciente = new Paciente();

	$agenda = new Agenda();

	require "../librerias/registro_horas/vistas/tabla_dia.php";

}else{
	die("Error: falta el dia");
}

?>