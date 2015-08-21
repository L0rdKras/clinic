<?php

class Atencion{
	protected $id;
	public $name;
	public $blocks_number;

	public function __construct(){
		$this->id=0;
	}

	public function get_by_id($id){
		$busca = new Consulta("SELECT * FROM atentions WHERE id='$id'");

		if($busca->filas_resultado()>0)
		{
			$respuesta = $busca->resultado_arreglo();

			$this->id = $id;
			$this->name = $respuesta[0]["name"];
			$this->blocks_number = $respuesta[0]["blocks_number"];
			
			return true;
		}
		return false;
	}

}