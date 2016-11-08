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
	<?php wp_head(); ?>


</head>
<body <?php body_class(); ?>>
	<style>
		html{ margin-top: 0 !important;  }
	</style>
	<?php
	$postType = get_post_type() ? get_post_type() : $wp_query->query['post_type'];

	$titles = [
	'cursos_ctp' => 	['gender' => 'o', 'plural' => 'cursos', 'singular' => 'curso'],
	'varandas_ctp' => 	['gender' => 'a', 'plural' => 'varandas', 'singular' => 'varanda'],
	'projetos_ctp' => 	['gender' => 'o', 'plural' => 'projetos', 'singular' => 'projeto'],
	'publicacoes_ctp' =>['gender' => 'a', 'plural' => 'publicações', 'singular' => 'publicação']
	];

	global $title;
	$title = $titles[$postType];
	?>


	<div class="row row-menu">
		<div class="column large-12 menu">
			<img src="<?= get_template_directory_uri() ?>/assets/images/logo.png" alt="" class="logo">
			<div class="menu-social"></div>
			<nav class="menu-nav">
				<ul>
					<li class="<?= $postType == 'cursos_ctp' ? 'selected' : '' ?>">
						<a href="/cursos_ctp/curso-01">cursos</a>
					</li>
					<li class="<?= $postType == 'varandas_ctp' ? 'selected' : '' ?>">
						<a href="/varandas_ctp/varanda-01">varandas</a>
					</li>
					<li>
						<a href="#">projetos</a>
					</li>
					<li>
						<a href="#">publicações</a>
					</li>
					<li>
						<a href="#">institucional</a>
					</li>
					<li>
						<a href="#">buscar </a>
					</li>
				</ul>
			</nav>
		</div>
	</div>

	<div id="content">