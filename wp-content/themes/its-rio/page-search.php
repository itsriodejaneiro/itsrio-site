<?php 
get_header();
$title = $_GET['title'];
$post_type = isset($_GET['cpt']) ? $_GET['cpt'] : ['cursos_ctp','publicacoes_ctp','varandas_ctp','projetos_ctp'];
$info_areapesquisa = $_GET['info_areapesquisa'];

$args = ['title_like' => $title, 'post_type' => $post_type];

if(isset($_GET['info_areapesquisa']))
	$args[] = ['meta_query' => ['key' => 'info_areapesquisa', 'value' => $_GET['info_areapesquisa'], 'compare' => 'IN' ] ];

if(isset($_GET['cat']))
	$args['category__and'] = $_GET['cat'];

query_posts($args);
?>
<div class="row">
	<div class="column large-12">
	<br><br>
		<h2 class="list-title"> resultados da busca <div class="line"></div>
		</h2>
	</div>
	<div class="older-posts">
		<?php 
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				include(ROOT .'inc/post-box.php');
			}
			wp_reset_postdata();
		} else {
			?>
			<h3>Nenhum post foi encontrado</h3>
			<?php
		}
		?>
	</div>
</div>
<script>
	'use strict';
	setTimeout(()=>{
		$('.older-posts').masonry({
			columnWidth : '.large-4',
			selector : '.large-4',
			percentPosition: true,
		});
	}, 500);
</script>
<?php get_footer(); ?>