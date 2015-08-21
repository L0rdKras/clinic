<?php

extract($_GET);

$busca = new Consulta("SELECT * from atentions order by name");

$lista_atenciones = $busca->resultado_arreglo();

$busca->cambiar_consulta("SELECT * from disponibles_times WHERE id = '$id_horario'");

$array_horario = $busca->resultado_arreglo();

$info_horario = $array_horario[0];

$paciente = new Paciente();

$paciente->get_by_id($id_cliente);

require "../librerias/registro_horas/vistas/formulario_ingreso.php";

?>