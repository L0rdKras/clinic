function datos_vacios_paciente(){
	$("#nombres").val("");
	$("#apellidos").val("");
	$("#telefono").val("");
	$("#direccion").val("");
	$("#empresa").val("");
	$("email_paciente").val("");
}

function buscar_paciente()
{
	$.ajax({
		type : "GET",
		url : "invocador.php?app=crear_paciente&funcion=vistas/modal_busca",
		success : function(datos){
			$("<div id='modal_horas'>"+datos+"</div>").modal({
				overlayClose:true,
				overlayCss: {backgroundColor:"#000"}
			});
			accion_boton("btn_search_paciente",carga_pacientes_edicion,[]);
		}
	});
}

function carga_pacientes_edicion()
{
	var nombres = $("#nombre_paciente_agenda").val();
	var apellidos = $("#apellido_paciente_agenda").val();

	if(!vacio(nombres) || !vacio(apellidos))
	{
		$.ajax({
			type : "GET",
			url : "invocador.php?app=crear_paciente&funcion=pacientes_buscados",
			data:{nombres:nombres,apellidos:apellidos},
			success : function(datos)
			{
				$("#respuesta_pacientes").html(datos);
			}
		});
	}else{
		alert("No hay data de busqueda");
	}
}

function selecciona_paciente_edicion(id)
{
	if(confirm("Esa seguro de seleccionar este paciente?"))
	{
		$.ajax({
			type : "GET",
			url : "invocador.php?app=comun&funcion=carga_datos",
			data : {dato:id,campo:"id",tabla:"patients"},
			success : function(datos){
				try{
					var info = JSON.parse(datos);
					if(info.respuesta == "Exito")
					{
						$("#rut").val(info.rut);
						$("#nombres").val(info.first_name);
						$("#apellidos").val(info.last_name);
						$("#telefono").val(info.phone);
						$("#direccion").val(info.address);
						$("#empresa").val(info.company_id);
						$("#email_paciente").val(info.email);
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
					$("#email_paciente").val(info.email);
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
	var email = $("#email_paciente").val();

	var arreglo = [rut,nombres,apellidos,telefono,direccion,empresa,email];

	if(!campos_vacios(arreglo)){
		ejecuta_guardado(rut,nombres,apellidos,telefono,direccion,empresa,email);
	}else{
		alert("Debe completar todos los campos");
	}
}

function ejecuta_guardado(rut,nombres,apellidos,telefono,direccion,empresa,email)
{
	$.ajax({
		type : "POST",
		url : "invocador.php?app=crear_paciente&funcion=guarda_paciente",
		data : {rut:rut,nombres:nombres,apellidos:apellidos,telefono:telefono,direccion:direccion,empresa:empresa,email:email},
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