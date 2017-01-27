<?php
get_header();
$no_label = true;
$cat_classes = 'black';
?>
<div class="row">
	<div class="main-carousel-wrapper column large-12">
		<h2 class="list-title">
			<?= pll__('áreas de pesquisa'); ?>
			<div class="line"></div>
		</h2>
		<div class="area-pesquisa">
			<?php
			$areas = get_ctp_array('areas', true);
			$styles .= "@media screen and (min-width: 769px) {";
			foreach ($areas as $id => $area) { ?>
			<div id="slider_<?= $id ?>" data-filter=".area-<?= $id ?>" area-name="#<?= sanitize_title($area['post_title']) ?>"  class="slider four no-active filter" <?= get_thumbnail_style($id, 'card') ?>>
				<div class="color"></div>	
				<span class="box slider-title"><?= $area['post_title'] ?></span>
				<span class="slider-excerpt"><?= $area['post_excerpt'] ?></span>
				<span class="slider-text"></span>
				<span class="box link"><?= pll__('ver projetos desta área') ?></span>
				<?php $styles .= "#slider_$id {background-image: url('".get_thumbnail_url_full($id)."') !important;}"; ?>
			</div>
			<?php
		} 
		$styles .= "}";
		?>
	</div>
</div>
<div class="column large-12" id="projetos-ativos-title">
	<h2 class="list-title">
		<?= pll__('projetos ativos') ?> <small class="show-for-medium"><?= pll__("mostrando tudo") ?></small>
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
<div class="column large-12" id="projetos-encerrados-title">
	<h2 class="list-title">
		<?= pll__('projetos encerrados') ?> <small class="show-for-medium"><?= pll__("mostrando tudo") ?></small>
		<div class="line"></div>
		<small class="show-for-small-only"><?= pll__("mostrando tudo") ?></small>
	</h2>
</div>
<div id="projetos-encerrados" class="older-posts">
	<?php
	$args = array(
		'post_type' => $postType,
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
			var areaName = jQuery(this).attr('area-name');
			$('#projetos-encerrados-title,#projetos-ativos-title').show();

			if($(this).hasClass('active') || (e.target == button[0] && button.text() == '<?= pll__("ver todos os projetos") ?>')){
				$grid.isotope({ filter: filterValue });
				$grid2.isotope({ filter: '*' });
				$('.list-title small').html('<?= pll__("mostrando tudo") ?>');
				button.text("<?= pll__('ver projetos desta área') ?>");
				jQuery('.area-pesquisa .slider').removeClass('active').removeClass('no-hover');
				active = false;
				if($(window).width() < 770)
					$('html, body').animate({ scrollTop: $('.older-posts').offset().top - 150 }, 300);
				else
					$('html, body').animate({ scrollTop: 0 }, 300);

				location.hash = '';

				return;
			}

			location.hash = areaName;

			if(active){
				jQuery('.area-pesquisa .slider').removeClass('active');
			}else{
				jQuery('.area-pesquisa .slider').removeClass('no-active');
			}

			$('html, body').animate({ scrollTop: $('.older-posts').offset().top - 150 }, 300);

			active = true;
			jQuery(this).addClass('active');
			button.text('<?= pll__("ver todos os projetos") ?>');
			var a = $( this );
			var filterValue = a.attr('data-filter');
			$grid.isotope({ filter: filterValue });
			$grid2.isotope({ filter: filterValue });

			$('.list-title small').html('<u>'+a.find('.slider-title').text()+'</u>'+ ' <i>&times;</i>');

			$('.list-title small i').click(function(){
				$('html, body').animate({ scrollTop: 0 }, 300);
				$grid.isotope({ filter: '*' });
				$grid2.isotope({ filter: '*' });
				button.text("<?= pll__('ver projetos desta área') ?>");
				$('.list-title small').html('<?= pll__("mostrando tudo") ?>');
				jQuery('.area-pesquisa .slider').removeClass('active').removeClass('no-hover').addClass('no-active');
				location.hash = '';
				active = false;

				$('#projetos-encerrados-title,#projetos-ativos-title').show();
			});
		});


		if(location.hash != ''){
			jQuery('.area-pesquisa .slider[area-name="'+location.hash+'"]').trigger('click');
		}
	},1000);
</script>
<?php get_footer(); ?>
