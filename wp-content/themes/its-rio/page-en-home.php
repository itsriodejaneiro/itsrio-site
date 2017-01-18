<?php get_header(); the_post(); ?>
<div class="row">
	<?php the_content();  ?>
</div>

<script>
	var scrolling = true;
	var lastScrollTop = 0;

	jQuery(document).ready(function(){
		jQuery('.main-carousel,.home-area-carousel').flickity({
			wrapAround: true,
		});
	});
</script>
<?php get_footer(); ?>