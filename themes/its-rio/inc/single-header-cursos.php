<?php 
$no_label = true; 
?>
<div class="row row-menu header-single" <?= get_thumbnail_style(get_the_ID(),'full'); ?>>
	<div class="row">
		<div class="column small-12">
			<h1><?php the_title() ?></h1>
			<?php $label = 'professores'; include(ROOT.'inc/palestrantes.php'); wp_reset_postdata(); ?>
			<div class="line"></div>
		</div>
		<div class="column small-12 medium-4">
			<?php if(!$closed): ?>
				<p class="dates show-for-small-only">
					<?= pll__('inscrições até') ?>
					<b><?= date('d/m',strtotime($meta['info_inscfim'][0]))	 ?></b>
					<br>
					<?= pll__('início do curso') ?>
					<b><?= date('d/m',strtotime($meta['info_data'][0]))	 ?></b>
				</p>
				<p class="box-title show-for-medium">data</p>
				<p class="box show-for-medium">
					<?= pll__('inscrições até') ?>
					<?= date('d/m',strtotime($meta['info_inscfim'][0]))	 ?>
					|
					<?= pll__('início do curso') ?>
					<?= date('d/m',strtotime($meta['info_data'][0]))	 ?>
				</p>
			<?php else: ?>
				<p class="box-title"><?= pll__('Curso sem previsão de lançamento') ?></p>
			<?php endif; ?>
		</div>
		<div class="column small-12 medium-4 end">
			<p class="box-title show-for-medium"><?= pll__('categorias') ?></p>
			<?php include(ROOT.'inc/categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php include(ROOT.'inc/single/menu.php') ?>
		<div class="sidebar">
			<?php if(!$closed): ?>
				<a class="link button large curved-shadow" target="_blank" href="<?= $meta['typeform_url'][0] ?>" data-mode="<?= $meta['typeform_layout'][0] ?>"><?=  isset($meta['formbutton_text']) ? $meta['formbutton_text'][0] : strtolower(pll__('inscreva-se')) ?></a>
			<?php else: ?>
				<a class="link button large curved-shadow" target="_blank" href="<?= $meta['typeform_url'][0] ?>" data-mode="<?= $meta['typeform_layout'][0] ?>"><?= pll__('novas turmas') ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>
<!--<div class="header-single-menu-fix"></div>-->