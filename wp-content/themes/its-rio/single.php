<?php
get_header();
the_post();
$meta = get_post_meta(get_the_ID());

include('inc/single-header-'.str_replace('_ctp', '', get_post_type()).'.php');

?>

<div class="row row-menu">
	<?php the_content();  ?>
</div>

<script type="text/x-template">

</script>

<?php get_footer(); ?>