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
		<?php
		global $postType;
		global $titles; 
		global $lang; 

		$postType = get_post_type() ? get_post_type() : $wp_query->query['post_type'];

		$titles = [
		'cursos_ctp' => 	['gender' => 'o', 'plural' => 'cursos', 'singular' => 'curso'],
		'varandas_ctp' => 	['gender' => 'a', 'plural' => 'varandas', 'singular' => 'varanda'],
		'projetos_ctp' => 	['gender' => 'o', 'plural' => 'projetos', 'singular' => 'projeto'],
		'publicacoes_ctp' =>['gender' => 'a', 'plural' => 'publicações', 'singular' => 'publicação'],
		'comunicados_ctp' =>['gender' => 'a', 'plural' => 'acontece', 'singular' => 'acontece'],
		'page' =>['gender' => 'o', 'plural' => 'institucionais', 'singular' => 'institucional']
		];

		global $title;
		$title = $titles[$postType];


	/*if(is_front_page()){
		?>
		<div class="home-cover" v-html="home_cover"></div>
		<?php
	}*/
	?>

	<div class="row row-menu fixed">
		<div class="column large-12 menu-container">
			<i class="fa fa-bars hide-for-large" onclick="$('.menu-nav').toggleClass('active')"></i>
			<?php if(is_front_page()){ ?>
			<h1><a href="/"><img src="<?= get_template_directory_uri() ?>/assets/images/logo-home.svg" alt="ITS - Instituto de Tecnologia e Sociedade do Rio" class="logo"></a></h1>
			<?php } else { ?>
			<h1><a href="/"><img src="<?= get_template_directory_uri() ?>/assets/images/logo.svg" alt="ITS - Instituto de Tecnologia e Sociedade do Rio" class="logo"></a></h1>
			<?php } ?>
			<div class="menu-social show-for-large" >
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
					<li>
						<a href="#"><i class="fa fa-github"></i></a>
					</li>
					<li class="text">
						<a href="/pt/home" <?= $lang == 'pt' ? 'class="selected"' : '' ?>>português</a> 
						| 
						<a href="/en/en-home" <?= $lang == 'en' ? 'class="selected"' : '' ?>> english</a>
					</li>
				</ul>
			</div>
			<nav class="menu-nav ">
				<div>
					<ul>
						<?php wp_nav_menu('main') ?>
					</ul>
					<div class="line"></div>
					<div class="menu-mobile-footer show-for-small-only">
						<div class="redes"></div>
						<div class="contato">
							<h3>contato</h3>
							<?= esc_attr(get_option('footer_contacts')) ?>
						</div>
						<div class="trending"></div>
					</div>
				</div>
			</nav>
			<i class="search-button fa fa-search" onclick="jQuery('.search-box').removeClass('hide');"></i>
		</div>
	</div>
	
	<?php include(ROOT.'inc/search.php'); ?>

	<div id="content">
