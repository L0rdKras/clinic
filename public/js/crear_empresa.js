function datos_vacios_empresa(){
	$("#nombre").val("");
	$("#contacto").val("");
	$("#telefono").val("");
	$("#direccion").val("");
	$("#email_empresa").val("");
}

function revisa_rut_empresa(){
	var rut = $("#rut_empresa").val();

	rut = daformator(rut);

	if(valida_cadena(rut))
	{
		carga_datos_empresa(rut);
	}else{
		alert("RUT no valido");
		datos_vacios_empresa();
	}
}

function carga_datos_empresa(rut)
{
	$("#rut_empresa").val(rut);
	$.ajax({
		type : "GET",
		url : "invocador.php?app=comun&funcion=carga_datos",
		data : {dato:rut,campo:"rut",tabla:"companies"},
		success : function(datos){
			try{
				var info = JSON.parse(datos);
				if(info.respuesta == "Exito")
				{
					
					$("#nombre").val(info.name);
					$("#contacto").val(info.contact);
					$("#telefono").val(info.phone);
					$("#direccion").val(info.address);
					
					$("#email_empresa").val(info.email);
				}else{
					datos_vacios_empresa();

					alert("Empresa no registrada");
				}
				accion_boton("btn_guardar_empresa",guarda_empresa,[]);
			}catch(e){
				alert("Error");
				console.log(datos);
			}
		}
	});
}

function guarda_empresa(){
	//
	var rut = $("#rut_empresa").val();
	var nombre = $("#nombre").val();
	var contacto = $("#contacto").val();
	var telefono = $("#telefono").val();
	var direccion = $("#direccion").val();
	
	var email = $("#email_empresa").val();

	var arreglo = [rut,nombre,contacto,telefono,direccion,email];

	if(!campos_vacios(arreglo)){
		ejecuta_guardado_empresa(rut,nombre,contacto,telefono,direccion,email);
	}else{
		alert("Debe completar todos los campos");
	}
}

function ejecuta_guardado_empresa(rut,nombre,contacto,telefono,direccion,email)
{
	$.ajax({
		type : "POST",
		url : "invocador.php?app=crear_empresa&funcion=guarda_empresa",
		data : {rut:rut,nombre:nombre,contacto:contacto,telefono:telefono,direccion:direccion,email:email},
		success : function(datos){
			if(datos == "Guardo")
			{
				alert("Empresa Guardada");
				location.reload();
			}else{
				console.log(datos);
				alert("Hubo un error, la informacion no fue guardada");
			}
		}
	});
}