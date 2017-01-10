
<div class="horario show-for-small-only">
	<span class="box"> <?= get_area_pesquisa(); ?> </span>
</div>
<div class="info-left">
	<h2><?= the_title(); ?></h2>
	<div class="show-for-medium">
		<?php include('inc/palestrantes.php'); $posts->reset_postdata(); ?>
	</div>
</div>
<div class="info-right horario show-for-medium">
	<p><b>área de pesquisa</b></p>
	<span class="box"> <?= get_area_pesquisa(); ?> </span>
</div>