<div class="row row-menu header-single" <?= get_thumbnail_style($destaque_id,'full'); ?>>
	<div class="row">
		<div class="column large-12">
			<h1><?php the_title() ?></h1>
			<?php $label = 'palestrantes'; include(ROOT.'inc/palestrantes.php'); wp_reset_postdata(); ?>
			<div class="line"></div>
		</div>
		<div class="column medium-4 large-4">
			<?php if(!$closed): ?>
				<p class="dates show-for-small-only">
					<?= pll__('horário') ?> <b><?= date('d/m',strtotime($meta['info_data'][0])).' às '.$meta['info_hora'][0] ?></b><br>
					<?= pll__('inscrições até') ?> <b><?= date('d/m',strtotime($meta['info_inscfim'][0])) ?></b>
				</p>
				<p class="box-title show-for-medium"><?= pll__('horário') ?></p>
				<p class="box show-for-medium">
					<?= date('d/m',strtotime($meta['info_data'][0])).' às '.$meta['info_hora'][0] ?>
					|
					<?= pll__('inscrições até') ?>
					<?= date('d/m',strtotime($meta['info_inscfim'][0]))	 ?>
				</p>
			<?php else: ?>
				<p class="box-title"><?= pll__('Varanda encerrada') ?></p>
			<?php endif; ?>
		</div>
		<div class="column medium-4 large-4 end">
			<p class="box-title show-for-medium"><?= pll__('categorias'); ?></p>
			<?php $no_label = true; include(ROOT.'inc/categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php include(ROOT . 'inc/single/menu.php') ?>
		<div class="sidebar">
			<?php
			$btnText = pll__('inscreva-se'); 
			if($closed)
				$btnText = pll__('sugira um tema');
			?>
			<a class="link button large curved-shadow" target="_blank" href="<?= $meta['typeform_url'][0] ?>" data-mode="<?= $meta['typeform_layout'][0] ?>" ><?= $btnText; ?></a>
			
		</div>
	</div>
</div>
<div class="header-single-menu-fix"></div>
