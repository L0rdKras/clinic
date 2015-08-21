<?php

class Horario{
	protected $id;
	public $initiation;
	public $final;

	public function __construct(){
		$this->id=0;
	}

	public function get_by_id($id){
		$busca = new Consulta("SELECT * FROM disponibles_times WHERE id='$id'");

		if($busca->filas_resultado()>0)
		{
			$respuesta = $busca->resultado_arreglo();

			$this->id = $id;
			$this->initiation = $respuesta[0]["initiation"];
			$this->final = $respuesta[0]["final"];
			
			return true;
		}
		return false;
	}
}

?>