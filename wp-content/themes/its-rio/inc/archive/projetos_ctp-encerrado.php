<div class="column large-12">
	<h2 class="list-title">
		projetos encerrados
		<div class="line"></div>		
	</h2>
</div>
<?php 
$args = array(
	'post_type' => $postType,
	'post__not_in' => [$destaque_id],
	'posts_per_page' => '100',
	'meta_query'	=> array(
		['key' => 'projeto_encerrado',
		'value' => '1',
		'compare' => '=']
		)
	);

query_posts($args);

if (have_posts()) {
	while (have_posts()) {
		the_post();
		if($destaque_id != get_the_ID())
			include(ROOT .'inc/post-box.php');
	}
}

?>