<?php

if(isset($_GET['id']) && !empty($_GET['id']))
{
	extract($_GET);

	$agenda = new Agenda();

	if($agenda->get_by_id($id))
	{
		//$busca = new Consulta("SELECT * from atentions order by name");

		//$lista_atenciones = $busca->resultado_arreglo();

		$paciente = $agenda->return_patient();

		require "../librerias/registro_horas/vistas/formulario_edicion.php";
	}else{
		echo "Registro no Encontrado";
	}
}else{
	echo "Sin Datos";
}

?>