<?php
//solo para enteros positivos

function convertir_bloque($numero)
{
	$unidad = array('UN','DOS','TRES','CUATRO','CINCO','SEIS','SIETE','OCHO','NUEVE'); 
    $decenas = array('DIEZ','ONCE','DOCE', 'TRECE','CATORCE','QUINCE'); 
    $decena = array('DIECI','VEINTI','TREINTA','CUARENTA','CINCUENTA'  ,'SESENTA','SETENTA','OCHENTA','NOVENTA'); 
    $centena = array('CIENTO','DOSCIENTOS','TRESCIENTOS','CUATROCIENTOS','QUINIENTOS','SEISIENTOS','SETECIENTOS','OCHOCIENTOS','NOVECIENTOS');

    $valor_centena = (int) ($numero/100);

    $valor_decena = (int) (($numero-$valor_centena*100)/10);

    $decena_y_unidad = $numero-$valor_centena*100;

    $valor_unidad = $numero-$valor_centena*100-$valor_decena*10;

    $texto = "";

    if($numero == 100)
    {
    	return "CIEN";
    }else{
    	if($valor_centena>0){
    		$texto.=" ".$centena[$valor_centena-1];
    	}

    	if($decena_y_unidad>0){
    		//
	    	if($decena_y_unidad == 20)
	    	{
	    		$texto.=" VEINTE";
	    	}else{
	    		if($decena_y_unidad>9 && $decena_y_unidad<16){
	    			$texto.=" ".$decenas[$valor_unidad];
	    		}elseif ($valor_decena>0 && $decena_y_unidad>15) {
	    			$texto.=" ".$decena[$valor_decena-1];
		    		if($valor_unidad>0){
		    			if($valor_decena>2){
		    				//
		    				$texto.=" Y ".$unidad[$valor_unidad-1];
		    			}else{
		    				$texto.=$unidad[$valor_unidad-1];
		    			}
		    		}
	    		}else{
	    			if($valor_unidad>0){
		    			$texto.=" ".$unidad[$valor_unidad-1];
		    		}
	    		}
	    	}
    	}
    	
    }
    return $texto;
}

function numero_a_palabras($numero)
{
	$numero_formateado = number_format($numero);

	$arreglo = explode(",", $numero_formateado);

	$texto="";

	if($numero == 0){
		return "CERO";
	}

	$respuesta = array();

	for ($i=count($arreglo)-1; $i >= 0; $i--) { 
		# code...
		$respuesta[] = convertir_bloque($arreglo[$i]).$texto;
	}

	$texto.=$respuesta[0];

	if(isset($respuesta[1]))
	{
		if($respuesta[1]!=""){
			if($respuesta[1]==" UN")
			{
				$respuesta[1]=" MIL";
				
			}else{
				$respuesta[1].=" MIL";
			}
		}
		$texto=$respuesta[1].$texto;
	}

	if(isset($respuesta[2]))
	{
		if($respuesta[2]==" UN"){
			$respuesta[2].=" MILLON";
		}else{
			$respuesta[2].=" MILLONES";
		}
		$texto=$respuesta[2].$texto;
	}

	return trim($texto);

}

?>