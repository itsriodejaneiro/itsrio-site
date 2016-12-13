<?php $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full'); ?>
<div class="row row-menu header-single" style="background: url(<?= isset($img[0]) ? $img[0] : ''; ?>)">
	<div class="row">
		<div class="column large-12">
			<h1><?php the_title() ?></h1>
			<?php $label = 'palestrantes'; include('palestrantes.php'); wp_reset_postdata(); ?>
			<div class="line"></div>
		</div>
		<div class="column large-4">
			<?php if(!closed): ?>
				<p class="box-title">horário</p>
				<p class="box">direito e technologia</p>
			<?php else: ?>
				<p class="box-title">Varanda encerrada</p>
			<?php endif; ?>
		</div>
		<div class="column large-4 end">
			<p class="box-title">categorias</p>
			<?php $no_label = true; include('categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php include(ROOT . 'inc/single/menu.php') ?>
		<?php if(!$closed): ?>
			<a href="#" class="button large curved-shadow">inscreva-se</a>
		<?php else: ?>
			<a href="#" class="button large curved-shadow">sugira um tema</a>
		<?php endif; ?>
	</div>
</div>
<div class="header-single-menu-fix"></div>
