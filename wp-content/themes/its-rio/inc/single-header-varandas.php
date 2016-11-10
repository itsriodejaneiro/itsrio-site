<div class="row row-menu header-single">
	<div class="row">
		<div class="column large-12">
			<h1><?php the_title() ?></h1>
			<?php $label = 'palestrantes'; include('inc/palestrantes.php'); wp_reset_postdata(); ?>
			<hr>
		</div>
		<div class="column large-4">
			<p>horário</p>
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
		<div class="sidebar">
			<a href="#" class="btn-big curved-shadow">inscreva-se</a>
		</div>
	</div>
</div>