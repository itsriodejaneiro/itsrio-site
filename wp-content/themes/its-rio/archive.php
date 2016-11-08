<?php
get_header();
?>
<div class="row row-menu">
	<div class="column large-12 submenu">
		<div class="submenu_info">
			<h1>cursos</h1>
			<img src="http://localhost/wp-content/themes/divi3-master-52cd5a7ba82bf112c8a84aa3d9b0239e5961febc/images/logo.png" alt="">
			<p>Lorem ipsum dolor sit amet</p>
		</div>
		<div class="submenu_description">
			<p>o quê são os cursos?</p>
			<!-- <p class="o-que-sao_description"><?= $o_que_sao ?></p> -->
		</div>
		<div class="submenu_filter">
			filtrar cursos
		</div>

		<div class="show-hide">
			<a href="javascript:void(0);">mostrar</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="column large-12">
		<h1 class="list-title"><?= "próxim{$title['gender']}s {$title['plural']}" ?></h1>
		<?php
		$posts = new WP_Query(array(
			'post_type' => $post_type,
			'meta_key' => 'info_inscricoes',
			'meta_value' => date('Y-m-d'),
			'meta_compare' => '>='
			)
		);
		?>
		<div class="highlights">
			<?php
			if ($posts->have_posts()) {
				while ($posts->have_posts()) {
					$posts->the_post();
					$meta = get_post_meta(get_the_ID());
					?>
					<div class="img"> <?php the_post_thumbnail(); ?> </div>
					<div class="info">
						<div class="column large-8">
							<h2><?= the_title(); ?></h2>
							<?php include('inc/palestrantes.php'); $posts->reset_postdata(); ?>
						</div>
						<div class="column large-4">
							<p><b>horário</b></p>
							<span class="box"><?= $meta['info_datahorario'][0] ?></span>
						</div>
						<div class="column large-12"><hr></div>
						<div class="column large-8">
							<p class="excerpt"><?= the_excerpt(); ?></p>
						</div>
						<div class="column large-4">
							<?php include('inc/categories.php'); ?>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
	<div class="column large-12">
		<h1 class="list-title"><?= "{$title['plural']} antig{$title['gender']}s" ?></h1>
		<?php
		query_posts(array(
			'post_type' => $post_type,
			'meta_key' => 'info_inscricoes',
			'meta_value' => date('Y-m-d'),
			'meta_compare' => '<'
			)
		);

		if (have_posts()) {
			while (have_posts()) {
				the_post();
				?>
				<div class="column large-4 list-item end">
					<div class="img"><?= the_post_thumbnail(); ?></div>
					<?php include('inc/categories.php') ?>
					<div class="info">
						<?php include('inc/categories.php') ?>
						<h2><?= the_title(); ?></h2>
						<hr>
						<p class="excerpt"><?= the_excerpt(); ?></p>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>

<?php get_footer(); ?>
