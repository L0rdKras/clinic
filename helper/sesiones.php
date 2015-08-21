<?php
//Poner require "../entidades/Consulta_helper.php"
//en el script que llame a este archivo

function sesion_activa(){
	if (!isset($_SESSION["nick"])){
    	$_SESSION["nick"] = "GUEST";
	}
	if (!isset($_SESSION["nombre"])){
    	$_SESSION["nombre"] = "INVITADO";
	}
	if (!isset($_SESSION["permiso"])){
	    $_SESSION["permiso"] = "GUEST";
	}
	//return true;
	if($_SESSION['permiso']=="GUEST")
	{
		return false;
	}else{
		return true;
	}
}
