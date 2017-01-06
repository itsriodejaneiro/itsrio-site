<div class="row row-menu header-single" <?= get_thumbnail_style($destaque_id,'full'); ?>>
	<div class="row">
		<div class="column large-12">
			<h1><?php the_title() ?></h1>
			<p class="excerpt"><?= the_excerpt(); ?></p>
			<div class="line"></div>
		</div>
		<div class="column large-4">
			<p class="box-title">área de pesquisa</p>
			<p class="box"><?= $meta['info_areapesquisa'][0] ?></p>
		</div>
		<div class="column large-4 end">
			<p class="box-title">categorias</p>
			<?php $no_label = true; include('inc/categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php 
		include(ROOT . 'inc/single/menu.php');
		if(isset($meta['pdf']) && $meta['pdf'][0] != ''){
			?>
			<div class="sidebar">
				<a href="<?= $meta['pdf'][0] ?>" target="_blank" class="button large curved-shadow">leia o pdf</a>
			</div>
			<?php 
		} ?>
	</div>
</div>
<div class="header-single-menu-fix"></div>
