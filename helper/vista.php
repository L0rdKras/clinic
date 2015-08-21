<?php

function muestra_contenido($nombre_pagina,$plantilla,$data)
{

	extract($data);
	ob_start();
	$estado_sesion = sesion_activa();
	if(file_exists("../Vistas/$nombre_pagina.tpl.php")){
		require "../Vistas/$nombre_pagina.tpl.php";
		$contenido_web = ob_get_clean();
	    require "../Vistas/$plantilla.tpl.php";
	}else{
		die("Error ruta");
	}
	

}

function muestra_contenido_vista_compartida($nombre_pagina,$vista,$plantilla,$data)
{
	extract($data);
	ob_start();

	require "vistas/$vista.tpl.php";

	$contenido_web = ob_get_clean();

    require "vistas/$plantilla.tpl.php";
}