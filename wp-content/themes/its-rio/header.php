<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>

	<script src="https://use.fontawesome.com/cb38949964.js"></script>
	<link rel="stylesheet" href="<?= esc_url_raw('/wp-content/themes/its-rio/assets/css/its.css') ?>">
	<link rel="stylesheet" href="<?= esc_url_raw('/wp-content/themes/its-rio/assets/css/flickity.css') ?>">

</head>
<body <?php body_class(); ?>>
<div id="content_all">
	<style>
		html{ margin-top: 0 !important;  }
	</style>
	<?php
	global $postType;
	global $titles; 
	
	$postType = get_post_type() ? get_post_type() : $wp_query->query['post_type'];

	$titles = [
	'cursos_ctp' => 	['gender' => 'o', 'plural' => 'cursos', 'singular' => 'curso'],
	'varandas_ctp' => 	['gender' => 'a', 'plural' => 'varandas', 'singular' => 'varanda'],
	'projetos_ctp' => 	['gender' => 'o', 'plural' => 'projetos', 'singular' => 'projeto'],
	'publicacoes_ctp' =>['gender' => 'a', 'plural' => 'publicações', 'singular' => 'publicação'],
	'comunicados_ctp' =>['gender' => 'a', 'plural' => 'comunicados', 'singular' => 'comunicado'],
	'page' =>['gender' => 'o', 'plural' => 'institucionais', 'singular' => 'institucional']
	];

	global $title;
	$title = $titles[$postType];


	if(is_front_page()){
		?>
		<div class="home-cover" v-html="home_cover"></div>
		<?php
	}
	?>

	<div class="row row-menu <?= is_front_page() ? 'home' : 'fixed' ?>">
		<div class="column large-12 menu-container">
			<i class="fa fa-bars show-for-small-only"></i>
			<a href="/"><img src="<?= get_template_directory_uri() ?>/assets/images/logo.png" alt="" class="logo"></a>
			<div class="menu-social hide-for-small-only" >
				<ul>
					<li>
						<a href="#"><i class="fa fa-youtube-play"></i></a>
					</li>
					<li>
						<a href="#"><i class="fa fa-twitter"></i></a>
					</li>
					<li>
						<a href="#"><i class="fa fa-facebook"></i></a>
					</li>
					<li>
						<a href="#"><i class="fa fa-instagram"></i></a>
					</li>
					<li>
						<a href="#"><i class="fa fa-medium"></i></a>
					</li>
					<li class="text">
						<a href="#" class="selected">português</a> | <a href="#"> inglês</a>
					</li>
				</ul>
			</div>
			<nav class="menu-nav hide-for-small-only">
				<ul>
					<?php wp_nav_menu('main') ?>
					<!-- <li class="<?= $postType == 'cursos_ctp' ? 'selected' : '' ?>">
						<a href="/cursos_ctp">cursos</a>
					</li>
					<li class="<?= $postType == 'varandas_ctp' ? 'selected' : '' ?>">
						<a href="/varandas_ctp">varandas</a>
					</li>
					<li>
						<a href="#">projetos</a>
					</li>
					<li>
						<a href="#">publicações</a>
					</li>
					<li>
						<a href="#">institucional</a>
					</li> -->
				</ul>
			</nav>
			<i class="fa fa-search"></i>
		</div>
	</div>

	<div id="content">
