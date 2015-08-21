function datos_vacios_paciente(){
	$("#nombres").val("");
	$("#apellidos").val("");
	$("#telefono").val("");
	$("#direccion").val("");
	$("#empresa").val("");
}

function revisa_rut(){
	var rut = $("#rut").val();

	rut = daformator(rut);

	if(valida_cadena(rut))
	{
		carga_datos_cliente(rut);
	}else{
		alert("RUT no valido");
		datos_vacios_paciente();
	}
}

function carga_datos_cliente(rut)
{
	$("#rut").val(rut);
	$.ajax({
		type : "GET",
		url : "invocador.php?app=comun&funcion=carga_datos",
		data : {dato:rut,campo:"rut",tabla:"patients"},
		success : function(datos){
			try{
				var info = JSON.parse(datos);
				if(info.respuesta == "Exito")
				{
					
					$("#nombres").val(info.first_name);
					$("#apellidos").val(info.last_name);
					$("#telefono").val(info.phone);
					$("#direccion").val(info.address);
					$("#empresa").val(info.company_id);
				}else{
					datos_vacios_paciente();

					alert("Cliente no registrado");
				}
				accion_boton("btn_guardar",guarda_cliente,[]);
			}catch(e){
				alert("Error");
				console.log(datos);
			}
		}
	});
}

function guarda_cliente(){
	//
	var rut = $("#rut").val();
	var nombres = $("#nombres").val();
	var apellidos = $("#apellidos").val();
	var telefono = $("#telefono").val();
	var direccion = $("#direccion").val();
	var empresa = $("#empresa").val();

	var arreglo = [rut,nombres,apellidos,telefono,direccion,empresa];

	if(!campos_vacios(arreglo)){
		ejecuta_guardado(rut,nombres,apellidos,telefono,direccion,empresa);
	}else{
		alert("Debe completar todos los cambios");
	}
}

function ejecuta_guardado(rut,nombres,apellidos,telefono,direccion,empresa)
{
	$.ajax({
		type : "POST",
		url : "invocador.php?app=crear_paciente&funcion=guarda_paciente",
		data : {rut:rut,nombres:nombres,apellidos:apellidos,telefono:telefono,direccion:direccion,empresa:empresa},
		success : function(datos){
			if(datos == "Guardo")
			{
				alert("Cliente Guardado");
				location.reload();
			}else{
				console.log(datos);
				alert("Hubo un error, la informacion no fue guardada");
			}
		}
	});
}