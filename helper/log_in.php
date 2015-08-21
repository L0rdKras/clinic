<?php
session_start();
require("../conectar.php");
require("../helper/usuarios.php");
require("../ownlib/respuesta.php");

if($_SESSION["nombre"]=="INVITADO")
{
	if(isset($_POST['user']) && !empty($_POST['user']) && isset($_POST['pass']) && !empty($_POST['pass']))
	{
		if(clave_correcta( $_POST['user'] , $_POST['pass'] )=="SI")
		{
			$nuevo_numero=0;
			$datos=json_decode( retorna_json("localhost","datos_usuario",array("usuario"=>$_POST['user']) ) );
			$ahora=date('Y-m-d H:i:s');
			if($datos->{'numero_log'}=="-1"){
				$nuevo_numero=0;
				$qins=mysql_query("insert into estadouser(user,num,fecha) values('{$_POST['user']}','0','$ahora')");
			}else{
				$nuevo_numero=$datos->{'numero_log'}++;
				$qup=mysql_query("update estadouser set fechahora='$ahora', num='$nuevo_numero' where user='{$_POST['user']}'");
			}

			if($datos->{'activo'}==1 && $datos->{'cerrada'}==0)
			{
				$_SESSION["nombre"] = $datos->{'nick'};
		
				$_SESSION["permiso"] = $datos->{'tipo'};
				
				$_SESSION["localuser"]= "PAMPA"; //$datos->{'local'};
				
				$_SESSION['numero']= $nuevo_numero;

				echo "Logeado";
			}else{
				echo "Cuenta Usuario Cerrada";
			}


		}else{
			echo "Usuario o Clave Incorrectos";
		}
	}else{
		echo "Faltan Datos";
	}
}else{
	echo "Sesion Ya Iniciada";
}