<?php

class Consulta{
	protected $string_query;
	/*public function __construct($la_query){
		$this->string_query=$la_query;
	}*/

	public function __construct()
	{
		$a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
	}

	private function __construct0()
	{
		$this->string_query	=	"";
	}

	private function __construct1($la_query)
	{
		$this->string_query	=	$la_query;
	}

	private function conectar(){
		$str_datos = file_get_contents("../Configuracion/base_datos.json");
		$data_conexion=json_decode($str_datos,true);
		$conexion= new mysqli($data_conexion['Servidor'],$data_conexion['usuario'],$data_conexion['clave'],$data_conexion['bd']);
		return $conexion;
	}

	public function retorna_resultado(){
		$conexion=$this->conectar();
		$result=$conexion->query($this->string_query);
		$conexion->close();
		return $result;
	}

	public function filas_resultado(){		
		return $this->retorna_resultado()->num_rows;
	}

	public function numero_paginas($limite){
		$numero_filas=$this->filas_resultado();
		return ceil($numero_filas/$limite);		
	}

	public function devolver_por_pagina($pagina,$limite){
		if($pagina>0 && $pagina<=$this->numero_paginas()){			
			$inicio=($pagina-1)*$limite;	
			$conexion=$this->conectar();
			$result=$conexion->query($this->string_query." LIMIT $inicio,$limite");
			$conexion->close();
			return $result;
		}
		return false;
	}

	public function cambiar_consulta($nueva)
	{
		$this->string_query	=	$nueva;
	}

	public function resultado_arreglo()
	{
		$conexion=$this->conectar();
		$result=$conexion->query($this->string_query);

		$array;

		while($row = $result->fetch_array())
		{
			$array[] = $row;
		}

		$conexion->close();

		if($this->filas_resultado()>0)
		{
			return $array;			
		}else{
			$vacio = array();
			return $vacio;
		}
	}
}