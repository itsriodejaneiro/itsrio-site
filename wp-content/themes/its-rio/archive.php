<?php
get_header();
?>
<div class="row row-menu">
	<div class="column large-12 submenu">
		<div class="submenu_info">
			<h2>cursos</h2>
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
		<h2 class="list-title"><?= "próxim{$title['gender']}s {$title['plural']}" ?></h2>
		<?php
		$posts = new WP_Query(array(
			'post_type' => $post_type,
			'meta_key' => 'info_inscfim',
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
					<a href="<?= get_post_permalink() ?>">
						<div class="img">
							<?php the_post_thumbnail(); ?>
						</div>
					</a>
					<div class="info">
						<a href="<?= get_post_permalink() ?>">
							<div class="column large-8">
								<h2><?= the_title(); ?></h2>
								<?php $label = 'professores'; include('inc/palestrantes.php'); $posts->reset_postdata(); ?>
							</div>
							<div class="no-p horario">
								<p><b>horário</b></p>
								<span class="black box">
									<?php
									if($postType == 'cursos_ctp'){
										?>
										inscrições até
										<?= date('d/m',strtotime($meta['info_inscfim'][0]))	 ?>
										<br>
										início do curso
										<?= date('d/m',strtotime($meta['info_cursoinicio'][0]))	 ?>
										<?php
									}elseif($postType == 'varandas_ctp'){
										echo $meta['info_datahorario'][0];
									}
									?>
								</span>
							</div>
						</a>
						<div class="column large-12 no-p-r"><hr></div>
						<div class="column large-8">
							<a href="<?= get_post_permalink() ?>">
								<p class="excerpt raleway"><?= get_the_excerpt(); ?></p>
							</a>
						</div>
						<div class="column large-4 no-p categories">
							<?php $cat_classes = 'black'; include('inc/categories.php'); ?>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
	<div class="older-posts">
		<div class="column large-12">
			<h2 class="list-title"><?= "{$title['plural']} antig{$title['gender']}s" ?></h2>
		</div>
		<?php
		query_posts(array(
			'post_type' => $post_type,
			'meta_key' => 'info_inscfim',
			'meta_value' => date('Y-m-d'),
			'meta_compare' => '<'
			)
		);

		if (have_posts()) {
			while (have_posts()) {
				the_post();

				include(ROOT .'inc/post-box.php');
			}
		}
		?>
	</div>
</div>

<?php get_footer(); ?>
