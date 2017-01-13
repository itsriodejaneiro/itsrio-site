<div class="row row-menu header-single" <?= get_thumbnail_style($destaque_id,'full'); ?>>
	<div class="row">
		<div class="column large-12">
			<h1><?php the_title() ?></h1>
			<?php the_excerpt() ?>
			<div class="line"></div>
		</div>
		<div class="column large-4">
			<p class="box-title">publicado em</p>
			<p class="box"><?= the_date(); ?></p>
		</div>
		<div class="column large-4 end">
			<p class="box-title">categorias</p>
			<?php $no_label = true; include(ROOT . 'inc/categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php include(ROOT . 'inc/single/menu.php') ?>
	</div>
</div>
<div class="header-single-menu-fix"></div>
