<h2><?= $titulo?></h2>

<div class="datos_ingreso" id="data_fecha">
	<h3>Dia Atencion</h3>
	<p>
		<input type='hidden' name='formato_fecha' id="formato_fecha" value='yyyy/mm/dd'/>
		Fecha <input type="text" id="fecha_agenda" name="fecha_agenda" readonly size="7"/><input type='button' value='...' onclick='displayCalendar(document.getElementById("fecha_agenda"),document.getElementById("formato_fecha").value,this)' />
		<button id="btn_ver_dia">Ver</button>
	</p>
</div>

<div class="tabla_datos" id="registro_dia">
	<!--tabla con el detalle de las horas disponibles
	y las usadas-->
</div>