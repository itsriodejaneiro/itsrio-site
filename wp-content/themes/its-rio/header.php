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
	<meta name="viewport" content="width=device-width">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1.0"> -->
	<title><?php wp_title() ?></title>
	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?= esc_url_raw('/wp-content/themes/its-rio/assets/css/its.css').'?'.filemtime(ROOT.'assets/css/its.css') ?>">
	<link rel="stylesheet" href="<?= esc_url_raw('/wp-content/themes/its-rio/assets/css/flickity.css') ?>">
	<link rel="stylesheet" href="<?= esc_url_raw('/wp-content/themes/its-rio/assets/css/jquery.custom-scrollbar.css') ?>">
	<script src="/wp-content/themes/its-rio/assets/js/flickity.pkgd.min.js"></script>
	<script src="/wp-content/themes/its-rio/assets/js/isotope.pkgd.min.js"></script>
	<script src="/wp-content/themes/its-rio/assets/js/jquery.custom-scrollbar.min.js"></script>
	<script src="https://use.fontawesome.com/cb38949964.js"></script>
	<script>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
			n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
				document,'script','https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '903842739667609'); 
			fbq('track', 'PageView');
		</script>
		<noscript>
			<img height="1" width="1" style="display:none"src="https://www.facebook.com/tr?id=903842739667609&ev=PageView&noscript=1"/>
		</noscript>
		<!-- DO NOT MODIFY -->
		<!-- End Facebook Pixel Code -->
		<!-- Facebook Pixel Code -->
		<script>
			!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
				n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
					document,'script','https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '1336747553030986'); // Insert your pixel ID here.
		fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=1336747553030986&ev=PageView&noscript=1"
		/></noscript>
	</head>
	<body <?php body_class(); ?>>
		<div id="content_all" v-cloak>
			<?php
			global $postType;
			global $titles;
			global $lang;
			global $polylang;

			$postType = get_post_type() ? get_post_type() : $wp_query->query['post_type'];

			if($lang == 'pt'){
				$titles = [
				'cursos_ctp' => 	['plural' => pll__('cursos'), 'singular' => pll__('curso')],
				'varandas_ctp' => 	['plural' => pll__('varandas'), 'singular' => pll__('varanda')],
				'projetos_ctp' => 	['plural' => pll__('projetos'), 'singular' => pll__('projeto')],
				'publicacoes_ctp' =>['plural' => pll__('publicações'), 'singular' => pll__('publicação')],
				'comunicados_ctp' =>['plural' => pll__('acontece'), 'singular' => pll__('acontece')],
				'page' =>['plural' => pll__('institucionais'), 'singular' => pll__('institucional')]
				];
			}

			global $title;
			$title = $titles[$postType];
			$translationLang = $lang == 'pt' ? 'en' : 'pt';
			$translationUrl = $lang == 'en' ? '/pt/home/' : '/en/en-home/';	

			if(is_archive()){
				$translationUrl = str_replace($lang, $translationLang, $_SERVER['REQUEST_URI']);
			}
			if(is_single()){
				$translationUrl = get_permalink($polylang->model->get_translations('post', $post->ID)[$translationLang]);
			}
			?>

			<div class="row row-menu fixed">
				<div class="column large-12 menu-container">
					<i class="fa fa-bars hide-for-large" onclick="toggleMenu()"></i>
					<?php if(is_front_page()){ ?>
					<h1><a href="/"><img src="<?= get_template_directory_uri() ?>/assets/images/logo-home.svg" alt="ITS - Instituto de Tecnologia e Sociedade do Rio" class="logo"></a></h1>
					<?php } else { ?>
					<h1><a href="/"><img src="<?= get_template_directory_uri() ?>/assets/images/logo.svg" alt="ITS - Instituto de Tecnologia e Sociedade do Rio" class="logo"></a></h1>
					<?php } ?>
					<div class="menu-social show-for-large" >
						<ul>
							<li>
								<a href="https://www.youtube.com/user/ITSriodejaneiro" target="_blank"><i class="fa fa-youtube-play"></i></a>
							</li>
							<li>
								<a href="https://twitter.com/itsriodejaneiro" target="_blank"><i class="fa fa-twitter"></i></a>
							</li>
							<li>
								<a href="https://www.facebook.com/ITSriodejaneiro" target="_blank"><i class="fa fa-facebook"></i></a>
							</li>
							<li>
								<a href="https://www.instagram.com/itsriodejaneiro/" target="_blank"><i class="fa fa-instagram"></i></a>
							</li>
							<li>
								<a href="http://feed.itsrio.org" target="_blank"><i class="fa fa-medium"></i></a>
							</li>
							<li>
								<a href="https://github.com/itsriodejaneiro" target="_blank"><i class="fa fa-github"></i></a>
							</li>
							<li class="text">
								<a <?= $lang == 'pt' ? 'class="selected" href="#"' : 'href="'.$translationUrl.'"' ?>>português</a>
								|
								<a <?= $lang == 'en' ? 'class="selected" href="#"' : 'href="'.$translationUrl.'"' ?>> english</a>
							</li>
						</ul>
					</div>
					<div class="menu-nav-bg" onclick="toggleMenu()"></div>
					<nav class="menu-nav ">
						<div>
							<?php //wp_nav_menu('main') ?>
							<div class="menu-menu_pt-container">
								<ul id="menu-menu_pt" class="menu">
									<li id="menu-item-3615" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3615">
										<a href="/<?= $lang ?>/cursos"><?= pll__('cursos') ?></a>
									</li> 
									<li id="menu-item-3616" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3616">
										<a href="/<?= $lang ?>/varandas"><?= pll__('varandas') ?></a>
									</li> 
									<li id="menu-item-3617" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3617">
										<a href="/<?= $lang ?>/projetos"><?= pll__('projetos') ?></a>
									</li> 
									<li id="menu-item-3618" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3618">
										<a href="/<?= $lang ?>/publicacoes"><?= pll__('publicações') ?></a>
									</li> 
									<li id="menu-item-3619" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3619">
										<a href="/<?= $lang == 'en' ? 'en/institutional' : 'pt/institucional' ?>/"><?= pll__('institucional') ?></a>
									</li>
								</ul>
							</div>
							<div class="line"></div>
							<ul class="lang">
								<li>
									<a <?= $lang == 'pt' ? 'class="selected" href="#"' : 'href="'.$translationUrl.'"' ?>>português</a>
								</li>
								<li>
									<a <?= $lang == 'en' ? 'class="selected" href="#"' : 'href="'.$translationUrl.'"' ?>> english</a>
								</li>
							</ul>
							<div class="line"></div>
							<div class="menu-mobile-footer show-for-small-only">
								<div class="redes"></div>
								<div class="contato">
									<h3><?= pll__('contato') ?></h3>
									<?= esc_attr(get_option('footer_contacts')) ?>
								</div>
								<div class="trending"></div>
							</div>
						</div>
					</nav>
					<div class="scrollable-arrow"></div>
					<i class="search-button fa fa-search" onclick="toggleBusca()"></i>
				</div>
			</div>

			<?php include(ROOT.'inc/search.php'); ?>
			<div id="content">
