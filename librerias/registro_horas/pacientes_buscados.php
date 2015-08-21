<?php

$alguno = false;

$query = "SELECT * from patients WHERE 1=1 ";

if(isset($_GET['nombres']) && !empty($_GET['nombres']))
{
	$alguno = true;
	$campo = str_replace(" ", "%", $_GET['nombres']);
	$query.=" AND first_name like '%$campo%'";
}

if(isset($_GET['apellidos']) && !empty($_GET['apellidos']))
{
	$alguno = true;
	$campo = str_replace(" ", "%", $_GET['apellidos']);
	$query.=" AND last_name like '%$campo%'";
}

$query .= " order by last_name,first_name";

if($alguno)
{
	$busca = new Consulta($query);

	if($busca->filas_resultado()>0)
	{
		$lista_pacientes = $busca->resultado_arreglo();
		require "../librerias/registro_horas/vistas/tabla_pacientes.php";
	}
}
?>