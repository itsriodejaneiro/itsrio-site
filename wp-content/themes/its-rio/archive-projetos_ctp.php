<?php get_header(); ?>
<div class="row">
	<?php
	$no_label = true;
	$cat_classes = 'black';
		?>
		<div class="main-carousel-wrapper column large-12">
				<h2 class="list-title show-for-medium">
					áreas de pesquisa
					<div class="line"></div>
					<a href="javascript:void(0);" class="filter" data-filter=".area-0">Direitos e tecnologia</a><br>
					<a href="javascript:void(0);" class="filter" data-filter=".area-1">Democracia e Tecnologia</a><br>
					<a href="javascript:void(0);" class="filter" data-filter=".area-2">Repensando Inovação</a><br>
					<a href="javascript:void(0);" class="filter" data-filter=".area-3">Educação</a><br>
				</h2>
                <!-- <its-projetos inline-template>
                    <div class="main-carousel highlights-carousel">
                        <div class="banner">
                            <div v-for="(page, i) in pages" v-bind:class="{'active': i == 0 }" v-bind:id="'slider_'+ page.EINS_ID" class="slider"  @click="changePage(page)" v-bind:style="{ 'background-image' : 'url(http://ims.com.br/images/02/19/eins_img_1466220219.jpg)', 'width': bannerWidth }">
                                <span class="slider-title">{{ page.EINS_TITULO }}</span>
                        </div>
                    </div>
                </its-projetos> -->
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
	<?php include ROOT . 'inc/archive/projetos_ctp-encerrado.php'; ?>
</div>
<script>
	'use strict';
	setTimeout(function(){
		var $grid = $('.older-posts').isotope({
		  itemSelector: '.large-4',
		  layoutMode: 'fitRows'
		});
		var $grid2 = $('#projetos-encerrados').isotope({
		  itemSelector: '.large-4',
		  layoutMode: 'fitRows'
		});

		$('.filter').on( 'click', function() {
			var a = $( this );
		  var filterValue = a.attr('data-filter');
		  $grid.isotope({ filter: filterValue });
		  $grid2.isotope({ filter: filterValue });

		  $('.list-title small').html('<u>'+a.text()+'</u>'+ ' <i>&times;</i>');
		  $('.list-title small i').click(function(){
			  $grid2.isotope({ filter: '*' });
			  $('.list-title small').html('mostrando tudo');
		  });
		});


		// jQuery('.banner .slider').hover(function() {
		//     jQuery('.banner .slider').removeClass('active');
		//     jQuery(this).addClass('active');
		// });
	},1000);
</script>
<?php get_footer(); ?>
