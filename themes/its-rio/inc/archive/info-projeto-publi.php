
<div class="horario show-for-small-only">
	<span class="box"> <?= get_area_pesquisa($meta); ?> </span>
</div>
<div class="info-left">
	<h2><?= the_title(); ?></h2>
	<div class="show-for-medium">
		<?php include(ROOT.'inc/palestrantes.php'); if(isset($posts) && !is_null($posts)) $posts->reset_postdata(); ?>
	</div>
</div>
<div class="info-right horario show-for-medium">
	<p><b><?= pll__('área de pesquisa'); ?></b></p>
	<span class="box"> <?= get_area_pesquisa($meta); ?> </span>
</div>
