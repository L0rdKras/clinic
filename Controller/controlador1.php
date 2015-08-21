<?php
session_start();

//La hoja de estilo(css) y el archivo JavaScript(js)
//deben tener el mismo nombre que la pagina principal, 
//pero dentro de las carpetas css y js respectivamente
//Si se necesitan archivos adicionales para la pagina
//se guardaran en la capeta helpers_nombre de la pagina

require "helper/vista.php";
require "helper/revisiones.php";
require("conectar.php");
//require "entidades/Consulta.php";

function crear_ventana($nombre_pagina,$plantilla,$titulo){
	if(revisar_estado_log())
	{
		if(acceso_permitido($nombre_pagina,$_SESSION["permiso"]))
		{
			muestra_contenido($nombre_pagina,$plantilla,$titulo);
		}else{
			muestra_contenido("sin_autorizacion",$plantilla,'Sin Autorizacion');
		}
	}else{
		muestra_contenido("logear",$plantilla,"Logear");
	}
}
