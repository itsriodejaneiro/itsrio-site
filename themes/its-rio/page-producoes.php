<?php
/**
* Template Name: Página produções
*
*/
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
			<div id="slider_publicacoes_ctp" data-filter=".publicacoes_ctp" area-name="#<?= pll__('Publicações') ?>"  class="slider four no-active filter" <?= get_thumbnail_style('4256', 'card') ?>>
				<div class="color"></div>
				<span class="box slider-title"><?= pll__('publicações') ?></span>
				<span class="slider-excerpt"><?= 'A expressão Lorem ipsum em design gráfico e editoração é um texto padrão em latim utilizado na produção gráfica para preencher ' ?></span>
				<span class="slider-text"></span>
				<span class="box link"><?= pll__('ver publicações') ?></span>
				<?php $styles .= "#slider_publicacoes_ctp {background-image: url('".get_thumbnail_url_full('4256')."') !important;}"; ?>
			</div>
			<div id="slider_comunicados_ctp" data-filter=".comunicados_ctp" area-name="#<?= pll__('Publicações') ?>"  class="slider four no-active filter" <?= get_thumbnail_style('4256', 'card') ?>>
				<div class="color"></div>
				<span class="box slider-title"><?= pll__('comunicados') ?></span>
				<span class="slider-excerpt"><?= 'A expressão Lorem ipsum em design gráfico e editoração é um texto padrão em latim utilizado na produção gráfica para preencher ' ?></span>
				<span class="slider-text"></span>
				<span class="box link"><?= pll__('ver comunicados') ?></span>
				<?php $styles .= "#slider_comunicados_ctp {background-image: url('".get_thumbnail_url_full('4256')."') !important;}"; ?>
			</div>
			<div id="slider_videos_ctp" data-filter=".videos_ctp" area-name="#<?= pll__('vídeos') ?>"  class="slider four no-active filter" <?= get_thumbnail_style('4256', 'card') ?>>
				<div class="color"></div>
				<span class="box slider-title"><?= pll__('vídeos') ?></span>
				<span class="slider-excerpt"><?= 'A expressão Lorem ipsum em design gráfico e editoração é um texto padrão em latim utilizado na produção gráfica para preencher ' ?></span>
				<span class="slider-text"></span>
				<span class="box link"><?= pll__('ver vídeos') ?></span>
				<?php $styles .= "#slider_videos_ctp {background-image: url('".get_thumbnail_url_full('4256')."') !important;}"; ?>
			</div>
			<div id="slider_artigos_ctp" data-filter=".artigos_ctp" area-name="#<?= pll__('artigos') ?>"  class="slider four no-active filter" <?= get_thumbnail_style('4256', 'card') ?>>
				<div class="color"></div>
				<span class="box slider-title"><?= pll__('artigos') ?></span>
				<span class="slider-excerpt"><?= 'A expressão Lorem ipsum em design gráfico e editoração é um texto padrão em latim utilizado na produção gráfica para preencher ' ?></span>
				<span class="slider-text"></span>
				<span class="box link"><?= pll__('ver artigos') ?></span>
				<?php $styles .= "#slider_artigos_ctp {background-image: url('".get_thumbnail_url_full('4256')."') !important;}"; ?>
			</div>
		</div>
	</div>
	<div class="column large-12" id="projetos-ativos-title">
		<h2 class="list-title">
			<?= pll__('Produções') ?> <small class="show-for-medium"><?= pll__("mostrando tudo") ?></small>
			<div class="line"></div>
			<small class="show-for-small-only"><?= pll__("mostrando tudo") ?></small>
		</h2>
	</div>
	<div class="older-posts">
		<?php
		$args = array(
			'posts_per_page' => '100',
			'post_type' => array( 'videos_ctp', 'artigos_ctp', 'comunicados_ctp','publicacoes_ctp')
		);

		$query = new WP_Query($args);
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				include(ROOT .'inc/post-box.php');
			}
		}
		?>
	</div>
</div>
<script>
	'use strict';


	setTimeout(function(){
		var i = 0;
		$('.area-pesquisa .slider').each(function(){
			var obj = $(this), b = i*150;
			setTimeout(function(){ obj.show() }, b);
			i++;
		});

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

			if($(this).hasClass('active') || (e.target == button[0] && button.text() == '<?= pll__("ver todos as produções") ?>')){
				$grid.isotope({ filter: filterValue });
				$('.list-title small').html('<?= pll__("mostrando tudo") ?>');
				button.text("<?= pll__('ver produções desta área') ?>");
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
			button.text('<?= pll__("ver todos as produções") ?>');
			var a = $( this );
			var filterValue = a.attr('data-filter');
			console.log(filterValue)
			$grid.isotope({ filter: filterValue });

			if(typeof $('.older-posts[style*="height: 0px"]')[0] != 'undefined')
				$('#'+$('.older-posts[style*="height: 0px"]')[0].id + '-title').hide();

			$('.list-title small').html('<u>'+a.find('.slider-title').text()+'</u>'+ ' <i>&times;</i>');

			$('.list-title small').click(function(){
				$('html, body').animate({ scrollTop: 0 }, 300);
				$grid.isotope({ filter: '*' });
				$grid2.isotope({ filter: '*' });
				button.text("<?= pll__('ver produções desta área') ?>");
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
	},1500);
</script>
<?php get_footer(); ?>
