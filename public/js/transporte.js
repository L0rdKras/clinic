$(document).ready(function() {
    
    funciones_ingreso();
    funciones_busca_inf_diaria();
    funciones_busca_variedades_mes();
    funciones_control_productor_diario();
    funciones_control_ingreso_sociedad();
    funciones_control_ingreso_valle();
    funcciones_ingreso_data_egresos();
});

function funciones_ingreso(){
	//guardar_ingreso();
	agrega_temporal();
	salto_enter("corr","guia_ingreso");
	salto_enter("guia_ingreso","productor");
	calcular_kgrado("kneto","grado");
	calcular_kgrado("grado","btn_registra");
	$('#corr').validCampoFranz('0123456789');
	$('#guia_ingreso').validCampoFranz('0123456789');
	$('#kneto').validCampoFranz('0123456789');
	$('#grado').validCampoFranz('0123456789.');
}

function guardar_ingreso(){
	$("#btn_registra").on("click",function(){
		var arreglo = ['corr','guia_ingreso','productor','fecha','variedad','valle','kneto','grado','kgrado'];

		if(!vacios(arreglo)){
			//sigue guardarndo
			modal_espera();
			//registra();
		}else{
			alert("Revise los datos, hay campos sin completar");
		}
	});
}

function agrega_temporal(){
	//
	$("#btn_add_temporal").on("click",function(){
		var arreglo = ['corr','guia_ingreso','productor','fecha','variedad','valle','kneto','grado','kgrado'];

		if(!vacios(arreglo)){
			//sigue guardarndo
			modal_espera();
			al_temporal();
		}else{
			alert("Revise los datos, hay campos sin completar");
		}
	});
}

function calcular_kgrado(id,destino){
	$("#"+id).on("keypress",function(event){
		if(event.which == 13){
			if(vacio($("#kneto").val()))
			{
				$("#kneto").val("0");
			}
			if(vacio($("#grado").val()))
			{
				$("#grado").val("0");
			}

			var valor = Math.round(ejecuta_formula());

			$("#kgrado").val(valor);

			$("#"+destino).focus();
		}
	});
}

function ejecuta_formula(){
	var v1 = parseInt($("#kneto").val());
	var v2 = parseFloat($("#grado").val());
	var v3 = parseInt($("#grado_base").val());

	return (v1*v2)/v3;
}

function registra(){
	$.ajax({
		type : "POST",
		url: "invocador.php?app=ingreso_carga&funcion=guarda_registro",
		data: {corr: $("#corr").val(),guia: $("#guia_ingreso").val(),productor: $("#productor").val(),fecha: $("#fecha").val(),variedad: $("#variedad").val(),valle: $("#valle").val(),kneto: $("#kneto").val(),grado: $("#grado").val(),kgrado: $("#kgrado").val()},
		success : function(datos){
			//console.log(datos);
			try{
				var info = JSON.parse(datos);
				alert(info.mensaje);
				if(info.respuesta = "guardo"){
					//
					location.reload();
					/*$("#tabla_detalle").html(info.contenido).promise().done(function(){
					
						cierra_modal();
						limpia_campos();			
					});*/
				}else{
					cierra_modal();
				}
			}catch(e){
				alert(datos);
			}
		}
	});
}

function al_temporal(){
	$.ajax({
		type : "POST",
		url: "invocador.php?app=ingreso_carga&funcion=guarda_temporal",
		data: {corr: $("#corr").val(),guia: $("#guia_ingreso").val(),productor: $("#productor").val(),fecha: $("#fecha").val(),variedad: $("#variedad").val(),valle: $("#valle").val(),kneto: $("#kneto").val(),grado: $("#grado").val(),kgrado: $("#kgrado").val()},
		success : function(datos){
			//console.log(datos);
			try{
				var info = JSON.parse(datos);
				alert(info.mensaje);
				cierra_modal();
				
			}catch(e){
				$("#tabla_temporal").html(datos).promise().done(function(){
					cierra_modal();
					limpia_campos_temp();
					guarda_todo();
				});
			}
		}
	});
}

function guarda_todo(){
	//
	$("#btn_guarda_principal").on("click",function(){
		modal_espera();
		$.ajax({
			type : "POST",
			url: "invocador.php?app=ingreso_carga&funcion=guarda_todo",
			
			success : function(datos){
				//console.log(datos);
				try{
					var info = JSON.parse(datos);
					alert(info.mensaje);
					cierra_modal();
					
				}catch(e){
					$("#tabla_detalle").html(datos).promise().done(function(){
						$("#tabla_temporal").html("");
						cierra_modal();
						limpia_campos();
						
					});
				}
			}
		});
	});
}

function modal_espera(){
	$("<div id='cuadro_espera' class='waiting'><h2>Espera mientras el sistema trabaja...</h2></div>").modal({
		opacity:80,
		escClose: false,
		overlayCss: {backgroundColor:"#fff"}
	});
}

function cierra_modal(){
	$.modal.close();
}

function borrar_registro(id){
	if(confirm("Presione Aceptar para eliminar este registro")){
		modal_espera();
		$.ajax({
			type: "POST",
			url: "invocador.php?app=ingreso_carga&funcion=borra_registro",
			data: {id:id},
			success : function(datos){
				try{
					var info = JSON.parse(datos);
					alert(info.mensaje);
					if(info.respuesta = "borro"){
						//
						/*$("#tabla_detalle").html(info.contenido).promise().done(function(){
						
							cierra_modal();					
						});*/
						location.reload();
					}else{
						cierra_modal();
					}
				}catch(e){
					alert(datos);
				}
			}
		});
	}
}

function borrar_registro_temp(id){
	//
	if(confirm("Presione Aceptar para eliminar este registro")){
		modal_espera();
		$.ajax({
			type: "POST",
			url: "invocador.php?app=ingreso_carga&funcion=borra_registro_temporal",
			data: {id:id},
			success : function(datos){
				try{
					var info = JSON.parse(datos);
					alert(info.mensaje);
					
					cierra_modal();
					
				}catch(e){
					$("#tabla_temporal").html(datos).promise().done(function(){
						cierra_modal();
					
						guarda_todo();
					});
				}
			}
		});
	}
}

function limpia_campos(){
	$("#corr").val("");
	$("#guia_ingreso").val("");
	$("#productor").val("");
	$("#fecha").val("");
	$("#variedad").val("");
	$("#valle").val("");
	$("#kneto").val("");
	$("#grado").val("");
	$("#kgrado").val("");
}

function limpia_campos_temp(){
	//$("#corr").val("");
	//$("#guia_ingreso").val("");
	//$("#productor").val("");
	//$("#fecha").val("");
	$("#variedad").val("");
	//$("#valle").val("");
	$("#kneto").val("");
	$("#grado").val("");
	$("#kgrado").val("");
}

function funciones_busca_inf_diaria(){
	busca_datos();
	imprime_datos();
}

function busca_datos(){
	$("#btn_busca_diario").on("click",function(){
		var arreglo = ['fecha_inicio','fecha_termino'];

		if(!vacios(arreglo)){
			//sigue guardarndo
			modal_espera();
			busca_inf_diaria($("#fecha_inicio").val(),$("#fecha_termino").val());
		}else{
			alert("Debe indicar ambas fechas para hacer la busqueda");
		}
	});
}

function imprime_datos(){
	$("#btn_imprimir_diario").on("click",function(){
		var arreglo = ['fecha_inicio','fecha_termino'];

		if(!vacios(arreglo)){
			//sigue guardarndo
			//modal_espera();
			imprime_inf_diaria($("#fecha_inicio").val(),$("#fecha_termino").val());
		}else{
			alert("Debe indicar ambas fechas para hacer la busqueda");
		}
	});
}
function imprime_inf_diaria(inicio,termino){
	//
	window.open("invocador.php?app=inf_diaria&funcion=imprime&inicio="+inicio+"&termino="+termino);
}


function busca_inf_diaria(inicio,termino){
	$.ajax({
		type: "GET",
		url: "invocador.php?app=inf_diaria&funcion=busca",
		data: {inicio:inicio,termino:termino},
		success: function(datos){
			try{
				var info = JSON.parse(datos);
				alert(info.mensaje);
				if(info.respuesta = "encontro"){
					//
					$("#tabla_detalle").html(info.contenido).promise().done(function(){
					
						cierra_modal();					
					});
					//location.reload();
				}else{
					cierra_modal();
				}
			}catch(e){
				
				$("#tabla_detalle").html(datos).promise().done(function(){
					
						cierra_modal();					
				});
			}
		}
	});
}



function funciones_busca_variedades_mes(){
	busca_var_por_mes();
	imprime_var_por_mes();
}

function busca_var_por_mes(){
	$("#btn_busca_variedad_mes").on("click",function(){
		//
		var arreglo = ['fecha_inicio','fecha_termino'];

		if(!vacios(arreglo)){
			//sigue guardarndo
			modal_espera();
			busca_varxmes($("#fecha_inicio").val(),$("#fecha_termino").val());
		}else{
			alert("Debe indicar fecha de inicio y fin para hacer la busqueda");
		}
	});
}

function imprime_var_por_mes(){
	$("#btn_imprime_variedad_mes").on("click",function(){
		//
		var arreglo = ['fecha_inicio','fecha_termino'];

		if(!vacios(arreglo)){
			//sigue guardarndo
			//modal_espera();
			imprime_varxmes($("#fecha_inicio").val(),$("#fecha_termino").val());
		}else{
			alert("Debe indicar fecha de inicio y fin para hacer la busqueda");
		}
	});
}

function imprime_varxmes(inicio,termino){
	window.open("invocador.php?app=control_ingreso_variedad&funcion=imprime&inicio="+inicio+"&termino="+termino);
}

function busca_varxmes(inicio,fin){
	$.ajax({
		type: "GET",
		url: "invocador.php?app=control_ingreso_variedad&funcion=busca",
		data: {inicio:inicio,termino:fin},
		success: function(datos){
			try{
				var info = JSON.parse(datos);
				alert(info.mensaje);
				if(info.respuesta = "encontro"){
					//
					$("#tabla_detalle").html(info.contenido).promise().done(function(){
					
						cierra_modal();					
					});
					//location.reload();
				}else{
					cierra_modal();
				}
			}catch(e){
				
				$("#tabla_detalle").html(datos).promise().done(function(){
					
						cierra_modal();					
				});
			}
		}
	});
}

function funciones_control_productor_diario(){
	busca_productor_diario();
	imprime_productor_diario();
}

function busca_productor_diario(){
	$("#btn_busca_diario_productor").on("click",function(){
		var arreglo = ['productor_consultar','fecha_inicio','fecha_termino'];

		if(!vacios(arreglo)){
			//sigue guardarndo
			modal_espera();
			ejecuta_busqueda_productor_diario($("#productor_consultar").val(),$("#fecha_inicio").val(),$("#fecha_termino").val());
		}else{
			alert("Debe indicar productor,fecha inicio y fecha termino para hacer la busqueda");
		}
	});
}

function imprime_productor_diario(){
	$("#btn_imprime_diario_productor").on("click",function(){
		var arreglo = ['productor_consultar','fecha_inicio','fecha_termino'];

		if(!vacios(arreglo)){
			//sigue guardarndo
			//modal_espera();
			imprime_busqueda_productor_diario($("#productor_consultar").val(),$("#fecha_inicio").val(),$("#fecha_termino").val());
		}else{
			alert("Debe indicar productor,fecha inicio y fecha termino para hacer la impresion");
		}
	});
}

function ejecuta_busqueda_productor_diario(productor,inicio,fin){
	//
	$.ajax({
		type: "GET",
		url: "invocador.php?app=control_productor_diario&funcion=busca",
		data: {productor:productor,inicio:inicio,fin:fin},
		success: function(datos){
			try{
				var info = JSON.parse(datos);
				alert(info.mensaje);
				if(info.respuesta = "encontro"){
					//
					$("#tabla_detalle").html(info.contenido).promise().done(function(){
					
						cierra_modal();					
					});
					//location.reload();
				}else{
					cierra_modal();
				}
			}catch(e){
				
				$("#tabla_detalle").html(datos).promise().done(function(){
					
						cierra_modal();					
				});
			}
		}
	});
}

function imprime_busqueda_productor_diario(productor,inicio,fin){
	window.open("invocador.php?app=control_productor_diario&funcion=imprime&productor="+productor+"&inicio="+inicio+"&fin="+fin);
}

function funciones_control_ingreso_sociedad(){
	buscar_x_sociedad();
}

function buscar_x_sociedad(){
	$("#btn_busca_rango_sociedad").on("click",function(){
		var arreglo = ['fecha_inicio','fecha_termino'];

		if(!vacios(arreglo)){
			//sigue guardarndo
			modal_espera();
			ejecuta_busqueda_sociedad_diario($("#fecha_inicio").val(),$("#fecha_termino").val());
		}else{
			alert("Debe indicar fecha inicio y fecha termino para hacer la busqueda");
		}
	});
}

function ejecuta_busqueda_sociedad_diario(inicio,fin){
	//
	$.ajax({
		type: "GET",
		url: "invocador.php?app=control_ingreso_sociedad&funcion=busca",
		data: {inicio:inicio,termino:fin},
		success: function(datos){
			try{
				var info = JSON.parse(datos);
				alert(info.mensaje);
				if(info.respuesta = "encontro"){
					//
					$("#tabla_detalle").html(info.contenido).promise().done(function(){
					
						cierra_modal();					
					});
					//location.reload();
				}else{
					cierra_modal();
				}
			}catch(e){
				
				$("#tabla_detalle").html(datos).promise().done(function(){
					
						cierra_modal();					
				});
			}
		}
	});
}

function funciones_control_ingreso_valle(){
	busca_valle();
}

function busca_valle(){
	$("#btn_busca_rango_valle").on("click",function(){
		var arreglo = ['fecha_inicio','fecha_termino'];

		if(!vacios(arreglo)){
			//sigue guardarndo
			modal_espera();
			ejecuta_busqueda_valle_diario($("#fecha_inicio").val(),$("#fecha_termino").val());
		}else{
			alert("Debe indicar fecha inicio y fecha termino para hacer la busqueda");
		}
	});
}

function ejecuta_busqueda_valle_diario(inicio,fin){
	//
	$.ajax({
		type: "GET",
		url: "invocador.php?app=control_ingreso_valle&funcion=busca",
		data: {inicio:inicio,termino:fin},
		success: function(datos){
			try{
				var info = JSON.parse(datos);
				alert(info.mensaje);
				if(info.respuesta = "encontro"){
					//
					$("#tabla_detalle").html(info.contenido).promise().done(function(){
					
						cierra_modal();					
					});
					//location.reload();
				}else{
					cierra_modal();
				}
			}catch(e){
				
				$("#tabla_detalle").html(datos).promise().done(function(){
					
						cierra_modal();					
				});
			}
		}
	});
}

function funcciones_ingreso_data_egresos()
{
	$('#monto').validCampoFranz('0123456789');
	activar_boton("btn_agregar",agregar_data_vousher);
	//guardar_imp_vousher();
	activar_boton("btn_emitir_vousher",guardar_imp_vousher);

}

function agregar_data_vousher()
{
	//
	var glosa = $("#glosa").val();
	var cuenta_debe = $("#cuenta_debe").val();
	var cuenta_haber = $("#cuenta_haber").val();
	var monto = $("#monto").val();
	var tipo = $("#tipo").val();

	if(!vacio(glosa) && !vacio(monto) && !vacio(cuenta_debe) && !vacio(cuenta_haber))
	{
		agrega_temporal_vousher(glosa,cuenta_debe,cuenta_haber,monto,tipo);
	}else{
		alert("Faltan datos para agregar la cuenta");
	}


}

function agrega_temporal_vousher(glosa,cuenta_debe,cuenta_haber,monto,tipo){
	//
	$.ajax({
		type : "POST",
		url: "invocador.php?app=vousher_contable&funcion=add_detalle",
		data: {glosa:glosa,cuenta_debe:cuenta_debe,cuenta_haber:cuenta_haber,monto:monto,tipo:tipo},
		success : function(datos)
		{
			if(datos=="Guardo")
			{
				carga_tabla_detalle_vousher();
				calculta_total_vousher();
				limpia_datos_cuenta_vousher();

			}else{
				alert(datos);
			}
		}
	});
}

function carga_tabla_detalle_vousher()
{
	$.ajax({
		type : "GET",
		url: "invocador.php?app=vousher_contable&funcion=tabla_detalle_vousher",
		success : function(datos)
		{
			$("#detalle_vousher").html(datos);
		}
	});
}

function calculta_total_vousher()
{
	$.ajax({
		type : "GET",
		url: "invocador.php?app=vousher_contable&funcion=total_vousher",
		success : function(datos)
		{
			$("#total").val(datos);
		}
	});
}

function limpia_datos_cuenta_vousher()
{
	var glosa = $("#glosa").val("");
	var cuenta = $("#cuenta_debe").val("");
	var cuenta = $("#cuenta_haber").val("");
	var monto = $("#monto").val("");
	var tipo = $("#tipo").val("Debe");
}

function guardar_imp_vousher()
{
	var paguese = $("#paguese").val();
	var tipo_registro = $("#tipo_registro").val();
	var forma_de_pago = $("#forma_pago").val();
	var a_la_orden = $("#a_la_orden").val();

	var total = $("#total").val();

	console.log("test"+paguese+" "+tipo_registro+" "+forma_de_pago+" "+a_la_orden+" "+total)

	if(!vacio(paguese) && !vacio(tipo_registro) && !vacio(forma_de_pago) && !vacio(a_la_orden) && !vacio(total))
	{
		//revisar que tenga detalle
		$.ajax({
			type : "GET",
			url: "invocador.php?app=vousher_contable&funcion=cantidad_detalle",
			success : function(datos)
			{
				console.log(datos);
				if(datos>0){
					if(confirm("Confirma la emision del documento?"))
					{
						//
						guarda_vousher(paguese,tipo_registro,forma_de_pago,a_la_orden,total);
					}
				}else{
					alert("Sin Detalle");
				}
			}
		});
	}else{
		alert("Debe completar todos los datos");
	}

}

function guarda_vousher(paguese,tipo_registro,forma_de_pago,a_la_orden,total)
{
	$.ajax({
		type : "POST",
		url: "invocador.php?app=vousher_contable&funcion=guarda_vousher_bd",
		data: {paguese:paguese,tipo_registro:tipo_registro,forma_de_pago:forma_de_pago,a_la_orden:a_la_orden,total:total},
		success : function(datos)
		{
			try{
				//
				var info = JSON.parse(datos);

				if(info.respuesta == "Guardo"){
					//carga impresion
					location.href="imprimir_vousher.php?numero="+info.numero;
					console.log(datos);
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

function borra_del_vousher(id){}