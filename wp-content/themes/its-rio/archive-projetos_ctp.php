<?php
get_header();
$no_label = true;
$cat_classes = 'black';
?>
<div class="row">
	<div class="main-carousel-wrapper column large-12">
		<h2 class="list-title show-for-medium">
			áreas de pesquisa
			<div class="line"></div>
		</h2>
		<div class="area-pesquisa">
			<?php
			$areas = get_ctp_array('areas', true);
			foreach ($areas as $id => $area) { ?>
				<div id="slider_<?= $id ?>" data-filter=".area-<?= $id ?>" class="slider four no-active filter" style="background-image: url('http://ims.com.br/images/02/19/eins_img_1466220219.jpg')">
					<span class="box slider-title"><?= $area['post_title'] ?></span>
					<span class="slider-excerpt"><?= $area['post_excerpt'] ?></span>
					<span class="slider-text"><?= $area['content'] ?></span>
					<span class="box link">ver projetos dessa área</span>
				</div>
				<?php
			} ?>
		</div>
	</div>
	<div class="column large-12">
		<h2 class="list-title">
			projetos ativos <small>mostrando tudo</small>
			<div class="line"></div>
		</h2>
	</div>
	<div class="older-posts">
		<?php
		$args = array(
			'posts_per_page' => '100',
			'post_type' => 'projetos_ctp',
			'meta_query' => array(
				['key' => 'projeto_encerrado',
				'value' => '0',
				'compare' => '='])
			);

			query_posts($args);

			if (have_posts()) {
				while (have_posts()) {
					the_post();
					include(ROOT .'inc/post-box.php');
				}
			}
			?>
		</div>
		<div class="column large-12">
			<h2 class="list-title">
				projetos encerrados <small>mostrando tudo</small>
				<div class="line"></div>
			</h2>
		</div>
		<div id="projetos-encerrados" class="older-posts">
			<?php
			$args = array(
				'post_type' => $postType,
				'post__not_in' => [$destaque_id],
				'posts_per_page' => '100',
				'meta_query'    => array(
					['key' => 'projeto_encerrado',
					'value' => '1',
					'compare' => '=']
				)
			);

			query_posts($args);

			if (have_posts()) {
				while (have_posts()) {
					the_post();
					if ($destaque_id != get_the_ID()) {
						include(ROOT .'inc/post-box.php');
					}
				}
			}
			?>
		</div>

	</div>
	<script>
	'use strict';
	setTimeout(function(){
		var active = false;
		var $grid = $('.older-posts').isotope({
			itemSelector: '.large-4',
			layoutMode: 'fitRows'
		});
		var $grid2 = $('#projetos-encerrados').isotope({
			itemSelector: '.large-4',
			layoutMode: 'fitRows'
		});

		jQuery('.area-pesquisa .slider').hover(function(e) {
			if(!active)
				jQuery('.area-pesquisa .slider').removeClass('no-active');
			else
				jQuery('.area-pesquisa .slider').addClass('no-hover');
		});

		jQuery('.area-pesquisa .slider').mouseleave(function() {
			if(!active)
				jQuery('.area-pesquisa .slider').addClass('no-active');
		});

		jQuery('.area-pesquisa .slider').click(function(e) {
			var button = jQuery(this).find('.box.link');
			if(e.target == button[0] && button.text() == 'ver todos os projetos'){
				$grid2.isotope({ filter: '*' });
				$('.list-title small').html('mostrando tudo');
				jQuery('.area-pesquisa .slider').removeClass('active').removeClass('no-hover').addClass('no-active');
				active = false;
				return;
			}
			if(active){
				jQuery('.area-pesquisa .slider').removeClass('active');
			}else{
				jQuery('.area-pesquisa .slider').removeClass('no-active');
			}
			active = true;
			jQuery(this).addClass('active');
			button.text('ver todos os projetos');
			var a = $( this );
			var filterValue = a.attr('data-filter');
			$grid.isotope({ filter: filterValue });
			$grid2.isotope({ filter: filterValue });

			$('.list-title small').html('<u>'+a.find('.slider-title').text()+'</u>'+ ' <i>&times;</i>');
			$('.list-title small i').click(function(){
				$grid2.isotope({ filter: '*' });
				$('.list-title small').html('mostrando tudo');
				jQuery('.area-pesquisa .slider').removeClass('active').removeClass('no-hover').addClass('no-active');
				active = false;
			});
		});
	},1000);
	</script>
	<?php get_footer(); ?>
