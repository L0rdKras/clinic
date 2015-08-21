<?php

class Paciente{
	protected $id;
	public $first_name;
	public $last_name;
	public $rut;
	public $phone;
	public $address;
	public $company_id;

	public function __construct(){
		$this->id=0;
	}

	public function get_by_id($id){
		$busca = new Consulta("SELECT * FROM patients WHERE id='$id'");

		if($busca->filas_resultado()>0)
		{
			$respuesta = $busca->resultado_arreglo();

			$this->id = $id;
			$this->first_name = $respuesta[0]["first_name"];
			$this->last_name = $respuesta[0]["last_name"];
			$this->rut = $respuesta[0]["rut"];
			$this->phone = $respuesta[0]["phone"];
			$this->address = $respuesta[0]["address"];
			$this->company_id = $respuesta[0]["company_id"];
			return true;
		}
		return false;
	}
}

?>