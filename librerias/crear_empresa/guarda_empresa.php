<?php

if(confirma_datos_arreglo($_POST,array("rut","nombre","contacto","telefono","direccion","email")))
{
	extract($_POST);
	//busca
	$busca = new Consulta("SELECT * from companies WHERE rut = '$rut'");

	$ejecutor = new EjecutarSql();

	if($busca->filas_resultado()>0)
	{
		$respuesta = $busca->resultado_arreglo();

		$arreglo = $respuesta[0];
		//
		$ejecutor->ejecutar("UPDATE companies SET name='$nombre', contact='$contacto', address='$direccion',phone='$telefono',email='$email' WHERE id='{$arreglo['id']}'");
	}else{
		//
		$ejecutor->ejecutar("INSERT INTO companies(rut,name,contact,phone,address,email) values('$rut','$nombre','$contacto','$telefono','$direccion','$email')");
	}
	echo "Guardo";
}else{
	die("Error: Sin datos validos");
}

?>