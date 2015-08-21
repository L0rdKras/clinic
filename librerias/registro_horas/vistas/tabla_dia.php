<table>
	<tr>
		<td>HORARIO</td>
		<td>REGISTRO</td>
	</tr>
	<?php
	foreach ($respuesta as $key => $value) {
		?>
		<tr>
			<td><?= $value['initiation']."-".$value['final']?></td>
			<td>
				<?php 
					if($value['id'] == NULL){
						?><button class="btn_reservar" onclick="reservar('<?= $value['id_hd']?>')">Reservar</button><?php
					}else{						
						//$paciente->get_by_id($value['patient_id']);
						$agenda->get_by_id($value['id']);

						?>
						<p>
							<?= $agenda->return_patient()->last_name.",".$agenda->return_patient()->first_name?>
							<button class="btn_editar" onclick="editar('<?= $value['id']?>')">Editar</button>
						</p>
						<p class="estado_<?= $agenda->return_reservation_state()?>">
							Estado : <?= $agenda->return_reservation_state()?>
						</p>
						<?php
					}
				?>
			</td>
		</tr>
		<?php
	}
	?>
</table>