<?php

function existe($variable)
{
	if(isset($variable) && !empty($variable))
	{
		return true;
	}

	return false;
}

function confirma_datos_arreglo($arreglo,$variables)
{
	foreach ($variables as $key => $value) {
		# code...
		if(!existe($arreglo[$value]))
		{
			return false;
		}
	}
	return true;
}