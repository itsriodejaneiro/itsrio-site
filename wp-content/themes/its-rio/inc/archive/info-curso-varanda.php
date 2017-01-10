<div class="horario show-for-small-only">
	<span class="box">
		inscrições até
		<?= date('d/m',strtotime($meta['info_inscfim'][0]))	?>
		<?php
		if($postType == 'cursos_ctp')
			echo "| início do curso" . date('d/m',strtotime($meta['info_cursoinicio'][0]));
		?>
	</span>
</div>
<div class="info-left">
	<h2><?= the_title(); ?></h2>
	<div class="show-for-medium">
		<?php include('inc/palestrantes.php'); $posts->reset_postdata(); ?>
	</div>
</div>
<div class="info-right horario show-for-medium">
	<p><b>data</b></p>
	<span class="box">
		inscrições até
		<?= date('d/m',strtotime($meta['info_inscfim'][0]))	?>
		<?php
		if($postType == 'cursos_ctp')
			echo "| início do curso" . date('d/m',strtotime($meta['info_cursoinicio'][0]));
		?>
	</span>
</div>