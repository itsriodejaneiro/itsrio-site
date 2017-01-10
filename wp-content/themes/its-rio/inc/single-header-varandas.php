<div class="row row-menu header-single" <?= get_thumbnail_style($destaque_id,'full'); ?>>
	<div class="row">
		<div class="column large-12">
			<h1><?php the_title() ?></h1>
			<?php $label = 'palestrantes'; include(ROOT.'inc/palestrantes.php'); wp_reset_postdata(); ?>
			<div class="line"></div>
		</div>
		<div class="column large-4">
			<?php if(!$closed): ?>
				<p class="box-title">horário</p>
				<p class="box">
					<?= date('d/m',strtotime($meta['info_data'][0])).' às '.$meta['info_hora'][0] ?>
					|
					inscrições até
					<?= date('d/m',strtotime($meta['info_inscfim'][0]))	 ?>
				</p>
			<?php else: ?>
				<p class="box-title">Varanda encerrada</p>
			<?php endif; ?>
		</div>
		<div class="column large-4 end">
			<p class="box-title">área de pesquisa</p>
			<p class="box"><?= get_area_pesquisa() ?></p>
		</div>
		<div class="column large-4 end">
			<p class="box-title show-for-medium">categorias</p>
			<?php $no_label = true; include(ROOT.'inc/categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php include(ROOT . 'inc/single/menu.php') ?>
		<div class="sidebar">
			<?php if(!$closed): ?>
				<a href="#" class="button large curved-shadow">inscreva-se</a>
			<?php else: ?>
				<a href="#" class="button large curved-shadow">sugira um tema</a>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="header-single-menu-fix"></div>
