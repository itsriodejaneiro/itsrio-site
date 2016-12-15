<?php $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full'); ?>
<div class="row row-menu header-single" 
	style="background: url(<?= isset($img[0]) ? $img[0] : ''; ?>)">
	<div class="row">
		<div class="column large-12">
			<h1><?php the_title() ?></h1>
			<p class="excerpt">informações extra</p>
			<div class="line"></div>
		</div>
		<div class="column large-4">
			<p class="box-title">linha de pesquisa</p>
			<p class="box">direito e technologia</p>
		</div>
		<div class="column large-4 end">
			<p class="box-title">categorias</p>
			<?php $no_label = true; include('inc/categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php include(ROOT . 'inc/single/menu.php') ?>
		<div class="sidebar">
			<a href="#" class="button large curved-shadow">baixe o pdf</a>
		</div>
	</div>
</div>
<div class="header-single-menu-fix"></div>
