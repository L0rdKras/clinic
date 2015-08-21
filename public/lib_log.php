<?php
session_start();

require "../helper/sesiones.php";
require "../Entidades/Consulta.php";
require "../Entidades/EjecutarSql.php";
require "../Entidades/Usuario.php";
require "../helper/respuestas_json.php";

if(!sesion_activa())
{
	if(isset($_POST['user_name']) && !empty($_POST['user_name']) && isset($_POST['password']) && !empty($_POST['password']))
	{
		//
		extract($_POST);

		$usuario = new Usuario();

		if($usuario->cargar_por_nick($user_name))
		{
			//
			if($usuario->activo())
			{
				//
				if($usuario->comparar_clave($password))
				{
					$_SESSION['nick'] = $usuario->retornar_nick();
					$_SESSION['nombre'] = $usuario->retornar_nombre();
					$_SESSION['permiso'] = $usuario->retornar_cargo();

					echo formato_json(array("respuesta"=>"Exito","mensaje"=>"Autenticacion exitosa"));
				}else{
					//clave no valida
					echo formato_json(array("respuesta"=>"Error","mensaje"=>"Clave Invalida"));
				}
			}else{
				//usuario no activado
				echo formato_json(array("respuesta"=>"Error","mensaje"=>"Usuario no activado"));
			}
		}else{
			//nombre usuario no existe
			echo formato_json(array("respuesta"=>"Error","mensaje"=>"Usuario no valido"));
		}
	}else{
		//sin datos validos para iniciar sesion
		echo formato_json(array("respuesta"=>"Error","mensaje"=>"Sin Datos Validos"));
	}
}else{
	//Ya hay una sesion activa
	echo formato_json(array("respuesta"=>"Error","mensaje"=>"Ya hay una sesion activa"));
}

?>