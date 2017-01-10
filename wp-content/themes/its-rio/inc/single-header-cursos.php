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
					inscrições até
					<b><?= date('d/m',strtotime($meta['info_inscfim'][0]))	 ?></b>
					<br>
					início do curso
					<b><?= date('d/m',strtotime($meta['info_cursoinicio'][0]))	 ?></b>
				</p>
				<p class="box-title show-for-medium">data</p>
				<p class="box show-for-medium">
					inscrições até
					<?= date('d/m',strtotime($meta['info_inscfim'][0]))	 ?>
					|
					início do curso
					<?= date('d/m',strtotime($meta['info_cursoinicio'][0]))	 ?>
				</p>
			<?php else: ?>
				<p class="box-title">Curso sem previsão de lançamento</p>
			<?php endif; ?>
		</div>
		<div class="column small-12 medium-4 end">
			<p class="box-title show-for-medium">categorias</p>
			<?php include(ROOT.'inc/categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php include(ROOT.'inc/single/menu.php') ?>
		<div class="sidebar">
			<?php if(!$closed): ?>
				<a href="#" class="button large curved-shadow">inscreva-se</a>
			<?php else: ?>
				<a href="#" class="button large curved-shadow">novas turmas</a>
			<?php endif; ?>
		</div>
	</div>
</div>
<!--<div class="header-single-menu-fix"></div>-->