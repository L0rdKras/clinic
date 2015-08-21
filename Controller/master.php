<?php

//La hoja de estilo(css) y el archivo JavaScript(js)
//deben tener el mismo nombre que la pagina principal, 
//pero dentro de las carpetas css y js respectivamente
//Si se necesitan archivos adicionales para la pagina
//se guardaran en la capeta helpers_nombre de la pagina

if(file_exists("../helper/sesiones.php") && file_exists("../Entidades/Consulta.php") && file_exists("../Entidades/EjecutarSql.php") && file_exists("../Entidades/Usuario.php"))
{
	require "../helper/sesiones.php";
	require "../Entidades/Consulta.php";
	require "../Entidades/EjecutarSql.php";
	require "../helper/vista.php";
	require "../helper/validar.php";
	require "../Entidades/Usuario.php";

	require "../Entidades/Paciente.php";
	require "../Entidades/Agenda.php";

}else{
	die("Errores de Ruta");
}


//require "entidades/Consulta.php";

function crear_ventana($nombre_pagina,$plantilla,$data = array()){	
	if(sesion_activa())
	{
		muestra_contenido($nombre_pagina,$plantilla,$data);	
	}else{
		muestra_contenido("logear",$plantilla,array("titulo"=>"Logear"));
	}
}

function crear_ventana_vista_compartida($nombre_pagina,$vista,$plantilla,$data = array()){	
	if(revisar_estado_log())
	{
		if(acceso_permitido($nombre_pagina,$_SESSION["permiso"]))
		{
			muestra_contenido_vista_compartida($nombre_pagina,$vista,$plantilla,$data);
		}else{
			$titulo="Sin Autorizacion";
			muestra_contenido("sin_autorizacion",$plantilla,compact('titulo'));
		}
	}else{
		muestra_contenido("logear",$plantilla,"Logear");
	}
}