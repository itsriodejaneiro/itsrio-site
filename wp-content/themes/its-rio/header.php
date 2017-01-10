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
			<i class="search-button fa fa-search" onclick="jQuery('.search-box').removeClass('hide');"></i>
		</div>
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

	<div class="search-box hide">
		<div class="row">
			<div class="column large-12">
				<form action="<?= get_search_link() ?>" method="GET" id="formSearch">
					<button class="close-button" onclick="jQuery('.search-box').addClass('hide');">fechar <span class="icon">&times;</span></button>
					<label class="search-label" for="search">
						<h2>buscar por:</h2>
						<input type="text" id="search" name="title" placeholder="digite sua palavra-chave">
						<button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
					</label>

					<div class="filter-options">
						<h2>filtragem de conteúdo:</h2>

						<div class="filter">
							<h3 class="list-title" style="display: block; width: 100%;">
								área
								<div class="line"></div>
							</h3>
							<input type="checkbox" id="search_title_area" class="ocultar">
							<label class="label-tab" for="search_title_area"></label>
							<div style="overflow: hidden; width: 100%;"> 
								<input type="checkbox" id="search_cursos" name="cpt[]" value="cursos_ctp">
								<label for="search_cursos" class="box">cursos</label>

								<input type="checkbox" id="search_varandas" name="cpt[]" value="varandas_ctp">
								<label for="search_varandas" class="box">varandas</label>

								<input type="checkbox" id="search_projetos" name="cpt[]" value="projetos_ctp">
								<label for="search_projetos" class="box">projetos</label>

								<input type="checkbox" id="search_publicações" name="cpt[]" value="publicações_ctp">
								<label for="search_publicações" class="box">publicações</label>
							</div>

						</div>
						<div class="filter">
							<h3 class="list-title" style="display: block; width: 100%;">
								áreas de pesquisa
								<div class="line"></div>
							</h3>
							<input type="checkbox" id="search_title_linhas" class="ocultar">
							<label class="label-tab" for="search_title_linhas"></label>
							<div style="overflow: hidden; width: 100%;"> 
								<input type="checkbox" id="direito-tecnologia" value="0" name="info_areapesquisa[]">
								<label for="direito-tecnologia" class="box">direito e tecnologia</label>

								<input type="checkbox" id="repensando-inovacao" value="1" name="info_areapesquisa[]">
								<label for="repensando-inovacao" class="box">repensando inovação</label>

								<input type="checkbox" id="educacao" value="2" name="info_areapesquisa[]">
								<label for="educacao" class="box">democracia e tecnologia</label>

								<input type="checkbox" id="educacao" value="3" name="info_areapesquisa[]">
								<label for="educacao" class="box">educação</label>
							</div>
						</div>
						<div class="filter">
							<h3 class="list-title" style="display: block; width: 100%;">
								categorias de assunto
								<div class="line"></div>
							</h3>
							<input type="checkbox" id="search_title_categorias" class="ocultar">
							<label class="label-tab" for="search_title_categorias"></label>
							<div style="overflow: hidden; width: 100%;"> 
								<input type="checkbox" id="lorem-ipsum">
								<label for="lorem-ipsum" class="box">lorem ipsum</label>
							</div>
						</div>
					</div>

					<button class="button large advanced-search">busca avançada 
						<i class="fa fa-angle-up" aria-hidden="true"></i>
						<!--<i class="fa fa-angle-down" aria-hidden="true"></i>-->
					</button>
				</form>
			</div>
		</div>
	</div>

	<div id="content">
