<?php
get_header();
?>
<div class="row">
	<?php
	$destaque_id = 0; 

	$args = array(
		'numberposts' => 1,
		'orderby' => $post_type,
		'order' => 'DESC',
		'post_type' => 'post',
		);

	if(in_array($postType, ['cursos_ctp', 'varandas_ctp'])){
		$args = array(
			'post_type' => $post_type,
			'meta_key' => 'info_inscfim',
			'meta_value' => date('Y-m-d'),
			'meta_compare' => '>='
			);
	}
	
	$posts = new WP_Query($args);

	if ($posts->have_posts()) {
		?>
		<div class="column large-12">
			<?php 
			switch ($postType) {
				case 'projetos_ctp':
				$bannerTitle = 'projetos em destaque';
				$bannerCards = 'outros projetos';				
				break;
				case 'cursos_ctp':
				$bannerTitle = 'inscrições abertas';
				$bannerCards = 'cursos encerrados';				
				break;
				case 'publicacoes_ctp':
				$bannerTitle = 'publicações em destaque';
				$bannerCards = 'outras publicações';				
				break;
				case 'varandas_ctp':
				$bannerTitle = 'varandas em destaque';
				$bannerCards = 'varandas antigas';				
				break;

				default:
				break;
			}
			?>
			<h2 class="list-title">
				<?= "$bannerTitle" ?>
				<div class="line"></div>
			</h2>

			<div class="highlights" style="background-image: url(<?= get_thumbnail_url_full(get_the_ID()) ?>)">
				<?php
				while ($posts->have_posts()) {
					$posts->the_post();
					$meta = get_post_meta(get_the_ID());
					$destaque_id = get_the_ID();
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
						<div class="line"></div>
						<div class="column large-8 no-p">
							<a href="<?= get_post_permalink() ?>">
								<p class="excerpt raleway"><?= limit_excerpt(get_the_excerpt(), 270) ?></p>
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
			<h2 class="list-title">
				<?= $bannerCards ?>
				<div class="line"></div>		
			</h2>
		</div>
		<?php
		if(in_array($postType, ['cursos_ctp', 'varandas_ctp'])){
			$args = array(
				'post_type' 	=> $post_type,
				'relation'		=> 'OR',
				'post__not_in'	=> [$destaque_id],
				'meta_query'	=> array(
					['meta_key' => 'info_inscfim',
					'meta_value' => date('Y-m-d'),
					'meta_compare' => '<'
					],
					['meta_key' => 'info_inscfim',
					'meta_value' => '',
					'meta_compare' => '='
					],
					)
				);
		}else{
			$args[] = ['exclude' => $destaque_id];
		}
		query_posts($args);

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
