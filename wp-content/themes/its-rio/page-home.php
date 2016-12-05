<?php get_header(); the_post(); ?>
<div class="row">
	<?php the_content();  ?>
</div>

<script>
	jQuery(window).scroll(function(){
		if(jQuery(this).scrollTop() >= jQuery(window).height() && jQuery('.row.row-menu').hasClass('home')){
			jQuery('.row.row-menu').addClass('fixed').removeClass('home');
			jQuery('.home-cover').remove();
			jQuery('html, body').animate({scrollTop: 0}, 5);
		}
	});
	jQuery(document).ready(function(){
		jQuery('.main-carousel,.home-area-carousel').flickity({
			wrapAround: true,
			// arrowShape: 'm30.4,103c-0.8,0.8-1.8,1.2-2.9,1.2s-2.1-0.4-2.9-1.2c-1.6-1.6-1.6-4.2 0-5.8l51-51-51-51c-1.6-1.6-1.6-4.2 0-5.8 1.6-1.6 4.2-1.6 5.8,0l53.9,53.9c1.6,1.6 1.6,4.2 0,5.8l-53.9,53.9z'; //http://www.flaticon.com/categories/arrows
		});
	});
</script>
<?php get_footer(); ?>