<h2><?= $titulo?></h2>

<div class="datos_ingreso" id="data_ingreso">
	<p>Rut : <input type="text" id="rut"></p>
	<p>Nombres : <input type="text" id="nombres"></p>
	<p>Apelidos : <input type="text" id="apellidos"></p>
	<p>Telefono : <input type="text" id="telefono"></p>
	<p>Direccion : <input type="text" id="direccion"></p>

	<p>
		Empresa : 
		<select name="empresa" id="empresa">
			<option value=""></option>
			<?php
			foreach ($lista_empresas as $key => $value) {
				?><option value="<?= $value['id']?>"><?= $value['name']?></option> <?php
			}
			?>
		</select>
	</p>

	<p>
		<button id="btn_guardar">Guardar Paciente</button>
	</p>
</div>