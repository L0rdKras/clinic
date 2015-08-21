<?php

function asignar_numero_atencion_vousher_muestra($n_atencion,$usuario)
{
	$ver_detalle=mysql_query("select * from detalleventa where NUMATENCION='$n_atencion'");
	while($row=mysql_fetch_array($ver_detalle)){
		$revisar_v_muestra=mysql_query("select * from vmuestras where codigo='".$row['COD_ART1']."' and estado='PENDIENTE' and user='$usuario' order by id");
		if($row_2=mysql_fetch_array($revisar_v_muestra)){
			$actualizar=mysql_query("update vmuestras set NATENCION='$n_atencion',reviso='Sistema',estado='Venta:Espera' where id='".$row_2['id']."'");
		}
	}
}

function asignar_venta_vousher_muestra($n_atencion,$numero_doc,$tipo_doc)
{	
	$fecha=date("Y/m/d");
	$actualizar=mysql_query("update vmuestras set estado='Vendido',ndocs='$numero_doc',tdocs='$tipo_doc',fechadevuelto='$fecha' where NATENCION='$n_atencion'");
}

function cancela_venta_caja_vousher_muestra($n_atencion)
{	
	$fecha=date("Y/m/d");
	$actualizar=mysql_query("update vmuestras set estado='Cancelada en Caja',fechadevuelto='$fecha' where NATENCION='$n_atencion'");
}