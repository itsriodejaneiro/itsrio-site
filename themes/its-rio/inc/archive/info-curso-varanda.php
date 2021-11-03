<div class="horario show-for-small-only">
	<div class="box">
		<?php
		if($postType == 'varandas_ctp'){
			echo date('d/m',strtotime($meta['info_data'][0])).' às '.$meta['info_hora'][0];
		} 
		if($postType == 'cursos_ctp'){
			echo  pll__('inscrições até') .' '. date('d/m',strtotime($meta['info_inscfim'][0])). " | ".pll__('início do curso')." " . date('d/m',strtotime($meta['info_data'][0]));
		}
		?>
	</div>
</div>
<div class="info-left">
	<h2><?= the_title(); ?></h2>
	<div class="show-for-medium">
		<?php include(ROOT.'inc/palestrantes.php'); if(!is_null($posts)) $posts->reset_postdata(); ?>
	</div>
</div>
<div class="info-right horario show-for-medium">
	<p><b><?= pll__('data') ?></b></p>
	<span class="box">
		<?php
		if($postType == 'varandas_ctp'){
			echo date('d/m',strtotime($meta['info_data'][0])).' às '.$meta['info_hora'][0];
		} 
		if($postType == 'cursos_ctp'){
			echo  pll__('inscrições até') .' '. date('d/m',strtotime($meta['info_inscfim'][0])). " | ".pll__('início do curso')." " . date('d/m',strtotime($meta['info_data'][0]));
		}
		?>
	</span>
</div>
