<div class="row row-menu header-single" <?= get_thumbnail_style($destaque_id,'full'); ?>>
	<div class="row">
		<div class="column large-12">
			<h1><?php the_title() ?></h1>
			<div class="show-for-medium excerpt">
				<?php the_excerpt() ?>
			</div>
			<div class="line"></div>
		</div>
		<div class="column large-4">
			<p class="box-title"><?= pll__('publicado em') ?></p>
			<p class="box"><?= the_date(); ?></p>
		</div>
		<div class="column large-4 end">
			<p class="box-title"><?= pll__('categorias') ?></p>
			<?php $no_label = true; include(ROOT . 'inc/categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php include(ROOT . 'inc/single/menu.php');

		if(isset($meta['saiba_mais']) && $meta['saiba_mais'][0] != ''){
			?>
			<div class="sidebar">
				<a class="button large curved-shadow" target="_blank" href="<?= $meta['saiba_mais'][0] ?>" target="_blank"><?=  isset($meta['formbutton_text']) ? $meta['formbutton_text'][0] : strtolower(pll__('Saiba Mais')) ?></a>
			</div>
			<?php 
		}
		?>
	</div>
</div>
<div class="header-single-menu-fix"></div>
