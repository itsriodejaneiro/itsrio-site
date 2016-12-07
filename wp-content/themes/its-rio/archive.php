<?php
get_header();
?>
<div class="row">
	<?php
	$posts = new WP_Query(array(
		'post_type' => $post_type,
		'meta_key' => 'info_inscfim',
		'meta_value' => date('Y-m-d'),
		'meta_compare' => '>='
		)
	);
	if ($posts->have_posts()) {
		?>
		<div class="column large-12">
			<h2 class="list-title"><?= "próxim{$title['gender']}s {$title['plural']}" ?></h2>

			<div class="highlights" style="background-image: url(<?= get_thumbnail_url_full(get_the_ID()) ?>)">
				<?php
				while ($posts->have_posts()) {
					$posts->the_post();
					$meta = get_post_meta(get_the_ID());
					?>
					<div class="info">
						<a href="<?= get_post_permalink() ?>">
							<div class="">
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
										| início do curso
										<?= date('d/m',strtotime($meta['info_cursoinicio'][0]))	 ?>
										<?php
									}elseif($postType == 'varandas_ctp')
									echo $meta['info_datahorario'][0];
									?>
								</span>
							</div>
						</a>
						<hr>
						<div class="column large-8 no-p">
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
				?>
			</div>
		</div>
		<?php
	}
	?>
	<div class="older-posts">
		<div class="column large-12">
			<h2 class="list-title"><?= "{$title['plural']} antig{$title['gender']}s" ?></h2>
		</div>
		<?php
		query_posts(array(
			'post_type' 	=> $post_type,
			'relation'		=> 'OR',
			'meta_query'	=> array(
				['meta_key' => 'info_inscfim',
				'meta_value' => date('Y-m-d'),
				'meta_compare' => '>='
				],
				['meta_key' => 'info_inscfim',
				'meta_value' => '',
				'meta_compare' => '='
				],
				)
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
<script>
	'use strict';
	setTimeout(()=>{
		$('.older-posts').masonry({
			columnWidth : '.large-4',
			selector : '.large-4',
			percentPosition: true,
		});
	}, 500);
</script>
<?php get_footer(); ?>
