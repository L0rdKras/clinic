<?php
/*
Clase para realizar operaciones en la base de datos MySQL
*/
class EjecutarSql
{
	protected $host;
	protected $usuario;
	protected $clave;
	protected $base_datos;
	protected $ultimo_id = 0;

	public function __construct()
	{
		$str_datos = file_get_contents("../Configuracion/base_datos.json");
		$data_conexion=json_decode($str_datos,true);
		$this->host=$data_conexion['Servidor'];
		$this->usuario=$data_conexion['usuario'];
		$this->clave=$data_conexion['clave'];
		$this->base_datos=$data_conexion['bd'];
	}

	private function conectar()
	{
		$conexion=new mysqli($this->host,$this->usuario,$this->clave,$this->base_datos);
		return $conexion;
	}
	private function conexion_activa()
	{
		$conexion=$this->conectar();
		if ($conexion->connect_errno)
		{
			return FALSE;
		}
		$conexion->close();
		return TRUE;
	}
	private function informe_error()
	{
		$conexion=$this->conectar();
		if ($conexion->connect_errno)
		{
			return $conexion->connect_error;
		}
		$conexion->close();
		return "Sin Error";
	}
	public function ejecutar($instruccion)
	{
		if($this->conexion_activa())
		{
			$conexion=$this->conectar();
			if($conexion->query($instruccion)===TRUE){
				$this->ultimo_id = $conexion->insert_id;
				$conexion->close();
				return true;
			}else{
				return "Problema con la instruccion";	
			}
		}else{
			return "Problema con la conexion: ".$this->informe_error();
		}
	}

	public function retorna_ultimo_id(){
		return $this->ultimo_id;
	}
}

