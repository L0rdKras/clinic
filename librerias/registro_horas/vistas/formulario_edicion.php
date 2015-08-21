<div class="datos_ingreso" id="data_lista">
	<h3>Datos Hora</h3>

	<p>
		Fecha: <?= $agenda->consultation_date?>
	</p>
	<p>
		Hora inicio : <?= $agenda->return_time()->initiation?>
	</p>
	<p>
		Hora Termino : <?= $agenda->return_time()->final?>
	</p>
	
</div>
<div class="datos_ingreso" id="data_cliente">
	<h3>Datos Paciente</h3>
	
	<p>
		Nombre Paciente : <?= $paciente->last_name.",".$paciente->first_name?>
	</p>
	<p>
		Telefono : <?= $paciente->phone?>
	</p>
	<p></p>
</div>
<div class="datos_ingreso" id="data_pendiente">
	<p>
		Especialista : 
	</p>
	<p>
		Atencion : 
		<?= $agenda->return_atention()->name?>
	</p>
</div>

<div class="datos_ingreso" id="mensaje_y_confirmacion">
	<p>
		Estado : 
		<select name="estado_reserva" id="estado_reserva">
			<option value="0" <?php if($agenda->confirm == 0){ ?>selected<?php }?> >Reservado</option>
			<option value="1" <?php if($agenda->confirm == 1){ ?>selected<?php }?> >Confirmado</option>
			<option value="2" <?php if($agenda->confirm == 2){ ?>selected<?php }?> >Llego</option>
			<option value="3" <?php if($agenda->confirm == 3){ ?>selected<?php }?> >Ausente</option>
			<option value="4" <?php if($agenda->confirm == 4){ ?>selected<?php }?> >Cancelo</option>

		</select>
		<button id="btn_edita_info">Guarda</button>
		<button id="btn_borra_reserva">Borrar</button>
	</p>
</div>