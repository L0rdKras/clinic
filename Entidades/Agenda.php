<?php

class Agenda{
	protected $id;
	public $consultation_date;
	protected $disponibles_time_id;
	protected $patient_id;
	protected $atention_id;
	protected $medic_id;
	public $confirm;

	public function __construct(){
		$this->id=0;
	}

	public function get_by_id($id){
		$busca = new Consulta("SELECT * FROM shedule WHERE id='$id'");

		if($busca->filas_resultado()>0)
		{
			$respuesta = $busca->resultado_arreglo();

			$this->id = $id;
			$this->consultation_date = $respuesta[0]["consultation_date"];
			$this->disponibles_time_id = $respuesta[0]["disponibles_time_id"];
			$this->patient_id = $respuesta[0]["patient_id"];
			$this->atention_id = $respuesta[0]["atention_id"];
			$this->medic_id = $respuesta[0]["medic_id"];
			$this->confirm = $respuesta[0]["confirm"];
			return true;
		}
		return false;
	}

	public function return_patient()
	{
		$paciente = new Paciente();
		if($paciente->get_by_id($this->patient_id))
		{
			return $paciente;
		}
		return false;
	}

	public function return_time()
	{
		$horario = new Horario();
		if($horario->get_by_id($this->disponibles_time_id))
		{
			return $horario;
		}
		return false;
	}

	public function return_atention()
	{
		$atencion = new Atencion();
		if($atencion->get_by_id($this->atention_id))
		{
			return $atencion;
		}
		return false;
	}

	public function return_reservation_state()
	{
		switch ($this->confirm) {
			case 0:
				return "Reservado";
				break;
			case 1:
				return "Confirmado";
				break;
			case 2:
				return "Llego";
				break;
			case 3:
				return "Ausente";
				break;
			case 4:
				return "Cancelo";
				break;
			
			default:
				return "Error";
				break;
		}
	}
}