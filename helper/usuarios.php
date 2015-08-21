<?php
require("../conectar.php");

function clave_correcta($nick,$clave)
{
	$qbusca=mysql_query("select * from usuarios where nick='$nick' and clave='$clave'");
	if($row=mysql_fetch_array($qbusca))
	{
		mysql_free_result($qbusca);
		return "SI";
	}
	mysql_free_result($qbusca);
	return "NO";
}