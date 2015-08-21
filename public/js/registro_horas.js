function carga_dia()
{
	var dia = $("#fecha_agenda").val();

	if(!vacio(dia))
	{
		ver_dia(dia);
	}else{
		alert("Debe indicar fecha para ver");
	}
}

function ver_dia(dia){
	$.ajax({
		type : "GET",
		url : "invocador.php?app=registro_horas&funcion=carga_dia",
		data : {dia:dia},
		success : function(datos){
			$("#registro_dia").html(datos);
		}
	});
}

function reservar(id_disponible){
	var dia = $("#fecha_agenda").val();

	if(confirm("Confirma que desea hacer la reserva?"))
	{
		$.ajax({
			type : "GET",
			url : "invocador.php?app=registro_horas&funcion=ventana_reserva",
			data : {dia:dia,id_disponible:id_disponible},
			success : function(datos){
				//
				$("<div id='modal_horas'><input type='hidden' id='id_horario' value='"+id_disponible+"'>"+datos+"</div>").modal({
					overlayClose:true,
					overlayCss: {backgroundColor:"#000"}
				});

				accion_boton("btn_buscar_paciente",carga_pacientes,[]);
			}
		});
	}
}

function carga_pacientes()
{
	var nombres = $("#nombre_paciente_agenda").val();
	var apellidos = $("#apellido_paciente_agenda").val();

	if(!vacio(nombres) || !vacio(apellidos))
	{
		$.ajax({
			type : "GET",
			url : "invocador.php?app=registro_horas&funcion=pacientes_buscados",
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

function selecciona_paciente_hora(id)
{
	if(confirm("Esa seguro de seleccionar este paciente?"))
	{
		var id_horario = $("#id_horario").val();
		var dia = $("#fecha_agenda").val();
		$.ajax({
			type : "GET",
			url : "invocador.php?app=registro_horas&funcion=ingreso_datos_agenda",
			data : {id_cliente:id,id_horario:id_horario,dia:dia},
			success : function(datos){
				$("#modal_horas").html(datos).promise().done(function(){
					elije_atencion();
				});
			}
		});
	}
}

function elije_atencion()
{
	$("#mensaje_y_confirmacion").fadeOut();

	$("#atencion").on("change",function(){
		//
		var atencion = $("#atencion").val();
		var dia = $("#fecha_agenda").val();
		var horario = $("#id_horario").val();

		if(!vacio(atencion && !vacio(dia) && !vacio(horario)))
		{
			$.ajax({
				type : "GET",
				url : "invocador.php?app=registro_horas&funcion=cuadro_confirmacion",
				data: {atencion:atencion,dia:dia,horario:horario},
				success : function(datos){
					$("#mensaje_y_confirmacion").html(datos).promise().done(function(){
						accion_boton("btn_confirma_pedido_hora",confirma_pedido_hora,[]);
						$("#mensaje_y_confirmacion").fadeIn();
					});
				}
			});
		}else{
			$("#mensaje_y_confirmacion").fadeOut();
		}
	});
}

function confirma_pedido_hora()
{
	var atencion = $("#atencion").val();
	var dia = $("#fecha_agenda").val();
	var horario = $("#id_horario").val();
	var paciente = $("#id_cliente").val();
	var segundo_bloque = $("#id_segunda_hora").val();

	if(!vacio(atencion && !vacio(dia) && !vacio(horario)))
	{
		if(confirm("Esta seguro de reservar esta hora?"))
		{
			$.ajax({
				type : "POST",
				url : "invocador.php?app=registro_horas&funcion=reserva",
				data : {atencion:atencion,dia:dia,horario:horario,segundo_bloque:segundo_bloque,paciente:paciente},
				success : function(datos)
				{
					if(datos == "Guardo")
					{
						location.reload();
					}else{
						alert(datos);
					}
				}
			});
		}
	}
}

function editar(id){

	if(confirm("Confirma que desea editar la reserva?"))
	{
		$.ajax({
			type : "GET",
			url : "invocador.php?app=registro_horas&funcion=ventana_edicion",
			data : {id:id},
			success : function(datos){
				//
				$("<div id='modal_horas'><input type='hidden' id='id_agenda' value='"+id+"'>"+datos+"</div>").modal({
					overlayClose:true,
					overlayCss: {backgroundColor:"#000"}
				});

				//funciones
				accion_boton("btn_edita_info",guarda_edicion,[]);
				accion_boton("btn_borra_reserva",borra_reserva,[]);
			}
		});
	}
}

function guarda_edicion()
{
	if(confirm("Confirma guardar el cambio?"))
	{
		var id = $("#id_agenda").val();
		var estado = $("#estado_reserva").val();

		$.ajax({
			type : "POST",
			url : "invocador.php?app=registro_horas&funcion=guardar_edicion",
			data : {id:id,estado:estado},
			success : function(datos)
			{
				if(datos == "Guardo")
				{
					alert("Datos Editados");
					location.reload();
				}else{
					alert(datos);
				}
			}
		});
	}
}

function borra_reserva()
{
	if(confirm("Confirma que quiere borrar la reserva?"))
	{
		var id = $("#id_agenda").val();

		$.ajax({
			type : "POST",
			url : "invocador.php?app=registro_horas&funcion=borrar_reserva",
			data : {id:id},
			success : function(datos)
			{
				if(datos == "Borro")
				{
					alert("Reserva Eliminada");
					location.reload();
				}else{
					alert(datos);
				}
			}
		});
	}
}