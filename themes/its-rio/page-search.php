<?php 
get_header();
$title = $_GET['title'];
$post_type = isset($_GET['cpt']) ? $_GET['cpt'] : ['cursos_ctp','publicacoes_ctp','varandas_ctp','projetos_ctp','comunicados_ctp'];
$info_areapesquisa = $_GET['info_areapesquisa'];

$args = ['title_like' => $title, 'post_type' => $post_type, 'lang' => $lang];

if(isset($_GET['info_areapesquisa']))
	$args[] = ['meta_query' => ['key' => 'info_areapesquisa', 'value' => $_GET['info_areapesquisa'], 'compare' => 'IN' ] ];

if(isset($_GET['cat']))
	$args['category__and'] = $_GET['cat'];

query_posts($args);
?>
<div class="row">
	<div class="column large-12">
	<br><br>
		<h2 class="list-title"> <?= pll__('resultados da busca') ?> <div class="line"></div>
		</h2>
	</div>
	<div class="column large-12 older-posts">
		<div class="row">
		<?php 
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				?>
				<?php
				include(ROOT .'inc/post-box.php');
				?>
				<?php
			}
			wp_reset_postdata();
		} ?>
		</div>
		<?php if(!have_posts()) {
			?>
			<br>
			<h6><?= pll__('Nenhum post foi encontrado') ?></h6>
			<br>
			<br>
			<?php
		}
		?>
	</div>
</div>
<?php get_footer(); ?>