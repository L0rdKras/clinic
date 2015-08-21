<h2>Pagina Inicio</h2>

<h3>Menu</h3>
<ul>
<?php
	foreach ($opciones as $key => $value) {
		?><li><a href="<?= $value?>"><?= $key?></a></li><?php
	}
?>
</ul>