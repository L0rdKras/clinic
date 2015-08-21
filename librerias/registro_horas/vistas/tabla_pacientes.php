<table>
	<tr>
		<td>RUT</td>
		<td>Nombre</td>
		<td>Seleccionar</td>
	</tr>
<?php
	foreach ($lista_pacientes as $key => $value) {
		?>
	<tr>
		<td><?= $value['rut']?></td>
		<td><?= $value['last_name'].",".$value['first_name']?></td>
		<td><input type="button" onclick="selecciona_paciente_hora('<?= $value['id']?>')"></td>
	</tr>	
		<?php
	}
?>
</table>