<?php

class Usuario{
	protected $id 		=	0;
	protected $nick 	=	"user";
	protected $nombre 	=	"Dummy";
	protected $clave 	=	"123456";
	protected $cargo 	=	"INVITADO";
	protected $email 	=	"dummy@empresa.cl";
	protected $estado	=	0;

	public function __construct(){
		$this->cargo="En espera";
	}

	public function cargar_por_nick($nickusuario){
		$busca=new Consulta("SELECT * from users where nick_name='".$nickusuario."'");
		$respuesta=$busca->retorna_resultado();
		if($row=$respuesta->fetch_array()){
			$this->id 		=	$row['id'];
			$this->nick 	=	$row['nick_name'];
			$this->nombre 	=	$row['full_name'];
			$this->clave 	=	$row['password'];
			$this->cargo 	=	$row['type'];
			$this->email 	=	$row['email'];
			$this->estado 	=	$row['state'];
			return true;
		}else{
			return false;
		}
	}

	public function comparar_clave($clave_ingresada){
		/*
		if($clave_ingresada==$this->clave){
			return true;
		}else{
			return false;
		}*/
		return password_verify($clave_ingresada, $this->clave);

	}

	public function activo()
	{
		if($this->estado == 1)
		{
			return true;
		}

		return false;
	}

	public function retornar_nombre(){
		return $this->nombre;
	}
	public function retornar_nick(){
		return $this->nick;
	}
	public function retornar_cargo(){
		return $this->cargo;
	}
	public function retornar_email(){
		return $this->email;
	}

	public function crear($data){
		//
		$variables_obligatorias = array("nick","nombre","clave","cargo","email");

		if(confirma_datos_arreglo($data,$variables_obligatorias))
		{
			foreach ($variables_obligatorias as $key => $value) {
				$this->$value = $data[$value];
			}

			if(existe($data["estado"]))
			{
				$this->estado = $data['estado'];
			}else{
				$this->estado = 0;
			}

			$this->clave = password_hash($this->clave,PASSWORD_BCRYPT);

			//guardar

			$ejecutor = new EjecutarSql();

			if($ejecutor->ejecutar("INSERT INTO users(nick_name,full_name,password,type,email,state) VALUES ('{$this->nick}','{$this->nombre}','{$this->clave}','{$this->cargo}','{$this->email}','{$this->estado}')"))
			{
				return true;
			}
		}

		return false;
	}
}