<div class="datos_ingreso" id="data_lista">
	<h3>Datos Hora a Registrar</h3>

	<p>
		Fecha: <?= $dia?>
	</p>
	<p>
		Hora inicio : <?= $info_horario['initiation']?>
	</p>
	<p>
		Hora Termino : <?= $info_horario['final']?>
	</p>
	<input type="hidden" id="id_horario" value="<?= $id_horario?>">
</div>
<div class="datos_ingreso" id="data_cliente">
	<h3>Datos Paciente</h3>
	<input type="hidden" id="id_cliente" value="<?= $id_cliente?>">

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
		<select name="atencion" id="atencion">
			<option value=""></option>
			<?php
			foreach ($lista_atenciones as $key => $value) {
				?><option value="<?= $value['id']?>"><?= $value['name']?></option> <?php
			}
			?>
		</select>
	</p>
</div>

<div class="datos_ingreso" id="mensaje_y_confirmacion">
	
</div>