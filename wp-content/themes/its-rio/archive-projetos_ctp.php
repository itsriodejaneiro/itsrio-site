<?php
get_header();
?>
<div class="row">
	<?php
	$destaque_id = 0;
	$no_label = true;
	$cat_classes = 'black';
		?>
		<div class="main-carousel-wrapper column large-12">
			<?php
				$bannerTitle = 'áreas de pesquisa';
				$bannerCards = 'projetos ativos';
				$label = '';
                ?>
				<h2 class="list-title show-for-medium">
					<?= $bannerTitle ?>
					<div class="line"></div>
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

    <script type="text/javascript">
        setTimeout(function(){
            jQuery('.banner .slider').hover(function() {
                jQuery('.banner .slider').removeClass('active');
                jQuery(this).addClass('active');
            });
        },1000);
    </script>
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
		}else{ echo 'fasda'; }

			include ROOT . 'inc/archive/projetos_ctp-encerrado.php';
		?>
	</div>
</div>
<script>
	// 'use strict';
	// setTimeout(()=>{
	// 	jQuery('.older-posts').masonry({
	// 		columnWidth : '.large-4',
	// 		selector : '.large-4',
	// 		percentPosition: true,
	// 	});
	// }, 1000);
</script>
<?php get_footer(); ?>
