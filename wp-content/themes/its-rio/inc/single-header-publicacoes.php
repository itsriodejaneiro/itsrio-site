<div class="row row-menu header-single">
	<div class="row">
		<div class="column large-12">
			<h1><?php the_title() ?></h1>
			<p class="excerpt"><?= the_excerpt(); ?></p>
			<hr>
		</div>
		<div class="column large-4">
			<p>linha de pesquisa</p>
			<p class="box">direito e technologia</p>
		</div>
		<div class="column large-4 end">
			<p>categorias</p>
			<?php $no_label = true; include('inc/categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php include(ROOT . 'inc/single/menu.php') ?>
	</div>
</div>
<div class="header-single-menu-fix"></div>
