<?php
session_start();

function revisar_estado_log()
{	
	if (!isset($_SESSION["nombre"])){
    	$_SESSION["nombre"] = "INVITADO";
	}
	if (!isset($_SESSION["permiso"])){
	    $_SESSION["permiso"] = "GUEST";
	}
	if (!isset($_SESSION["localuser"])){
	    $_SESSION["localuser"] = "PAMPA";
	}
	if (!isset($_SESSION["numero"])){
	    $_SESSION["numero"] = -1;
	}

	$qvn="select * from estadouser where user='{$_SESSION['nombre']}'";
	$rqvn=mysql_query($qvn);
	if($rwqvn=mysql_fetch_array($rqvn)){
		
		if($_SESSION['numero']!=$rwqvn['num']){
			$_SESSION["nombre"] = "INVITADO";
			$_SESSION["permiso"] = "GUEST";
			$_SESSION["localuser"] = "PAMPA";
			$_SESSION["numero"] = -1;
		}
	}	

	if($_SESSION['permiso']=="GUEST")
	{
		return false;
	}else{
		return true;
	}
}

function acceso_permitido($pagina,$permiso)
{	
	$result=mysql_query("SELECT * from tablapaginas where nombre='$pagina' and tusuario='$permiso'");
	
	if($row=mysql_fetch_array($result))
	{	
		return true;
	}		
	return false;
}