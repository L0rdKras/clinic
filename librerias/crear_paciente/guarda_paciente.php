<?php

if(confirma_datos_arreglo($_POST,array("rut","nombres","apellidos","telefono","direccion","empresa","email")))
{
	extract($_POST);
	//busca
	$busca = new Consulta("SELECT * from patients WHERE rut = '$rut'");

	$ejecutor = new EjecutarSql();

	if($busca->filas_resultado()>0)
	{
		$respuesta = $busca->resultado_arreglo();

		$arreglo = $respuesta[0];
		//
		$ejecutor->ejecutar("UPDATE patients SET first_name='$nombres', last_name='$apellidos', address='$direccion',phone='$telefono',company_id='$empresa',email='$email' WHERE id='{$arreglo['id']}'");
	}else{
		//
		$ejecutor->ejecutar("INSERT INTO patients(rut,first_name,last_name,phone,address,company_id,email) values('$rut','$nombres','$apellidos','$telefono','$direccion','$empresa','$email')");
	}
	echo "Guardo";
}else{
	die("Error: Sin datos validos");
}

?>