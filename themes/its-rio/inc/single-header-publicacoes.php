<?php 
global $lang;
$no_label = true; 
?>
<div class="row row-menu header-single" <?= get_thumbnail_style($destaque_id,'full'); ?>>
	<div class="row">
		<div class="column large-12">
			<h1><?php the_title() ?></h1>
			<div class="show-for-medium excerpt">
				<?= isset($meta['datapubli'][0]) && $meta['datapubli'][0] != '' ? $meta['datapubli'][0] : '' ?>
			</div>
			<div class="line"></div>
		</div>
		<div class="column medium-4 large-4">
			<a href="/<?= $lang ?>/publicacoes/#<?= $meta['info_areapesquisa'][0] ?>">
				<p class="box-title"><?= pll__('área de pesquisa'); ?></p>
				<p class="box"><?= get_area_pesquisa() ?></p>
			</a>
		</div>
		<div class="column medium-4 large-4 end">
			<p class="box-title"><?= pll__('categorias'); ?></p>
			<?php include(ROOT.'inc/categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php 
		include(ROOT.'inc/single/menu.php');
		if(isset($meta[$lang.'_pdf']) && $meta[$lang.'_pdf'][0] != ''){
			?>
			<div class="sidebar">
				<a href="<?= $meta[$lang.'_pdf'][0] ?>" target="_blank" class="button large curved-shadow"><?= pll__('leia o pdf') ?></a>
			</div>
			<?php 
		} ?>
	</div>
</div>
<div class="header-single-menu-fix"></div>
