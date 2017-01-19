<?php
get_header();
the_post();

$meta = get_post_meta(get_the_ID());
$closed = false;

if(isset($meta['info_inscfim'])){
	$fim = strtotime($meta['info_inscfim'][0]);
	if((int)$fim < time())
		$closed = true;
}

include('inc/single-header-'.str_replace('_ctp', '', get_post_type()).'.php');


?>
<div class="row row-menu">
	<?php the_content();  ?>
</div>

<?php get_footer(); ?>