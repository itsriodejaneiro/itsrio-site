<div class="row row-menu header-single">
	<div class="row">
		<div class="column large-12">
			<h1><?php the_title() ?></h1>
			<?php $label = 'professores'; include('palestrantes.php'); wp_reset_postdata(); ?>
			<hr>
		</div>
		<div class="column large-4">
			<p>data</p>
			<p class="box">
					inscrições até
					<?= date('d/m',strtotime($meta['info_inscfim'][0]))	 ?>
					<br>
					início do curso
					<?= date('d/m',strtotime($meta['info_cursoinicio'][0]))	 ?>
			</p>
		</div>
		<div class="column large-4 end">
			<p>categorias</p>
			<?php $no_label = true; include('categories.php') ?>
		</div>
	</div>
</div>
<div class="row row-menu spread-items header-single-menu">
	<div class="row single-menu-container">
		<?php include(ROOT . 'inc/single/menu.php') ?>
		<div class="sidebar">
			<a href="#" class="button large curved-shadow">inscreva-se</a>
		</div>
	</div>
</div>
<div class="header-single-menu-fix"></div>