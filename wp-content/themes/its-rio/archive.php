<?php
get_header();
?>
<div class="row">
	<?php
	$destaque_id = 0; 
	$no_label = true;
	$cat_classes = 'black';

	$args = array(
		'posts_per_page' => 1,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_type' => $post_type,
		);

	if(in_array($postType, ['publicacoes_ctp'])){
		$args = array(
			'post_type' => $post_type,
			'meta_key' => 'publi_banner',
			'meta_value' => '1',
			'meta_compare' => '='
			);
	}

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
		<div class="main-carousel-wrapper column large-12">
			<?php 
			switch ($postType) {
				case 'projetos_ctp':
				$bannerTitle = 'áreas de pesquisa';
				$bannerCards = 'projetos ativos';				
				$label = '';
				break;
				case 'cursos_ctp':
				$bannerTitle = 'inscrições abertas';
				$bannerCards = 'cursos futuros';
				$label = 'professores';				
				break;
				case 'publicacoes_ctp':
				$bannerTitle = 'publicações recentes';
				$bannerCards = 'publicações';
				$label = 'autores';
				break;
				case 'varandas_ctp':
				$bannerTitle = 'inscrições abertas';
				$bannerCards = 'varandas ITS';				
				$label = 'palestrantes';
				break;

				default:
				break;
			}

			if($bannerTitle != ""){
				?>
				<h2 class="list-title show-for-medium">
					<?= $bannerTitle ?>
					<div class="line"></div>
				</h2>
				<?php 
			} ?>
			<div class="main-carousel highlights-carousel">
				<?php
				$postsQtd = 0;
				while ($posts->have_posts()) {
					$posts->the_post();
					$postsQtd++;
					$meta = get_post_meta(get_the_ID());
					$destaque_id = get_the_ID();
					?>
					<div <?php post_class( 'carousel-cell highlights'); echo get_thumbnail_style($destaque_id,'banner'); ?> >
						<div class="color-hover"></div>
						<div class="info">
							<a href="<?= get_post_permalink() ?>">
								<div class="header">
									<?php 
									if(in_array($postType, ['cursos_ctp','varandas_ctp']))
										include ROOT.'inc/archive/info-curso-varanda.php';
									else
										include ROOT.'inc/archive/info-projeto-publi.php';
									?>
								</div>
							</a>
							<div class="line show-for-medium"></div>
							<div class="column large-12 no-p show-for-medium">
								<?php include('inc/categories.php'); ?>
							</div>
						</div>
						<div class="categories-wrapper show-for-small-only">
							<?php include('inc/categories.php'); ?>
						</div>
						<a href="<?= get_permalink() ?>" class="post-link"></a>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}
	if($postsQtd > 1){
		?>
		<script>
			jQuery(document).ready(function(){
				jQuery('.highlights-carousel').flickity({
					wrapAround: true,
					cellSelector: '.carousel-cell',
					setGallerySize : false
				});
			});
		</script>
		<?php
	}
	?>

	<div class="older-posts">
		<?php 
		if($bannerTitle != ""){
			?>
			<div class="column large-12">
				<h2 class="list-title">
					<?= $bannerCards ?>
					<div class="line"></div>		
				</h2>
			</div>
			<?php
		}

		if($postType == 'publicacoes_ctp'){
			$args = ['orderby' => 'post_date', 'order' => 'DESC'];
		}

		if(in_array($postType, ['cursos_ctp', 'varandas_ctp'])){
			$args = array(
				'relation'		=> 'OR',
				'meta_query'	=> array(
					['meta_key' => 'info_inscfim',
					'meta_value' => date('Y-m-d'),
					'meta_compare' => '<'],
					['meta_key' => 'info_inscfim',
					'meta_value' => '',
					'meta_compare' => '='])
				);
		}
		if($postType == 'projetos_ctp'){
			$args = array(
				'meta_query' => array(
					['key' => 'projeto_encerrado',
					'value' => '0',
					'compare' => '='])
				);
		}

		$args['posts_per_page'] = '100';
		$args['post__not_in'] = [$destaque_id];
		$args['post_type'] = $postType;

		query_posts($args);

		// echo $GLOBALS['wp_query']->request; 

		if (have_posts()) {
			while (have_posts()) {
				the_post();
				if($destaque_id != get_the_ID())
					include(ROOT .'inc/post-box.php');
			}
		}

		if($postType == 'projetos_ctp')
			include ROOT . 'inc/archive/projetos_ctp-encerrado.php';
		?>
	</div>
</div>
<script>
	'use strict';
	setTimeout(()=>{
		jQuery('.older-posts').masonry({
			columnWidth : '.large-4',
			selector : '.large-4',
			percentPosition: true,
		});
	}, 1000);
</script>
<?php get_footer(); ?>
