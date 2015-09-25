$(document).ready(function() {
    
    funciones_login();
    //funciones_logout();
    activar_al_enter("rut",revisa_rut);
    accion_boton("busca_paciente",buscar_paciente,[]);

    activar_al_enter("rut_empresa",revisa_rut_empresa);
    accion_boton("btn_ver_dia",carga_dia,[]);
});

function funciones_login()
{
	accion_boton("btn_logear",logear,[]);
}

function funciones_logout()
{
	if(confirm("Confirma la desconexion?"))
	{
		location.href="logout.php";
	}
}

function logear()
{
	var user_name = $("#nombre_usuario").val();
	var user_pass = $("#clave_usuario").val();

	if(!vacio(user_pass) && !vacio(user_name))
	{
		procesar_log(user_name,user_pass);
	}else{
		alert("Falta Informacion");
	}
}

function procesar_log(user,pass){
	//
	$.ajax({
		type : "POST",
		url : "lib_log.php",
		data : {user_name:user,password:pass},
		success : function(datos){
			try{
				var info = JSON.parse(datos);
				if(info.respuesta == "Exito"){
					location.reload();
				}else{
					alert(info.mensaje);
				}
			}catch(e){
				alert("Error");
				console.log(datos);
			}
		}
	});
}