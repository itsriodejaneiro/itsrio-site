<?php

add_filter( 'rwmb_meta_boxes', 'its_meta_boxes' );

function its_meta_boxes($meta_boxes) {
	$query_publicacoes = new WP_Query(['post_type' => 'publicacoes_ctp', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC']);
	$publicacoes = [];

	while ( $query_publicacoes->have_posts() ) : $query_publicacoes->the_post();
	$publicacoes[get_the_ID()]=get_the_title();
	wp_reset_query();
	wp_reset_postdata();
	endwhile;

	$query_pessoas = new WP_Query(['post_type' => 'pessoas', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC']);
	$pessoas = [];

	while ( $query_pessoas->have_posts() ) : $query_pessoas->the_post();
	$pessoas[get_the_ID()]=get_the_title();
	wp_reset_query();
	wp_reset_postdata();
	endwhile;

	$meta_boxes = array([
		'title'      => __('Informações', 'textdomain' ),
		'post_types' => ['publicacoes_ctp','projetos_ctp'],
		'fields'     => array(
			['id'   => 'info_header', 'name' => __('Linha de Pesquisa', 'textdomain'), 'type' => 'text']
			),
		],
		[
		'title'      => __('Informações', 'textdomain' ),
		'post_types' => ['cursos_ctp'],
		'fields'     => array(
			['id'   => 'info_inscinicio', 'name' => __('Início das Inscrições', 'textdomain'), 'type' => 'date'],
			['id'   => 'info_inscfim', 'name' => __('Fim das Inscrições', 'textdomain'), 'type' => 'date'],
			['id'   => 'info_cursoinicio', 'name' => __('Início do Curso', 'textdomain'), 'type' => 'date'],
			['id'   => 'info_valor', 'name' => __('Coluna com informações de valor', 'textdomain'), 'type' => 'wysiwyg'],
			)
		],
		[
		'title'      => __('Informações', 'textdomain' ),
		'post_types' => ['varandas_ctp'],
		'fields'     => array(
			['id'   => 'info_inscfim', 'name' => __('Data do evento', 'textdomain'), 'type' => 'date'],
			['id'   => 'info_datahorario', 'name' => __('Data e Horário', 'textdomain'), 'type' => 'text'],
			)
		],
		[
		'id'         => 'its_publicacoes',
		'title'      => __( 'Publicações', 'batuta_' ),
		'post_types' => [ 'projetos_ctp', 'varandas_ctp', 'cursos_ctp'],
		'context'    => 'normal',
		'priority'   => 'high',
		'autosave'   => true,
		'fields'     => array(
			array(
				'name'        => __( 'Publicações', 'batuta_' ),
				'id'          => "its_publicacoes",
				'type'        => 'select_advanced',
				'options'     => $publicacoes,
				'multiple'    => true,
				'std'         => 'value2',
				'placeholder' => __( 'Selecione as publicações', 'galeria_se' ),
				),
			)
		],
		[
		'id'         => 'home_destaques',
		'title'      => __( 'É um destaque na home?', 'batuta_' ),
		'post_types' => [ 'varandas_ctp', 'cursos_ctp','comunicados_ctp', 'publicacoes_ctp' ],
		'context'    => 'normal',
		'priority'   => 'high',
		'autosave'   => true,
		'fields'     => array(
			array(
				'name'        => __( 'É um banner da home', 'batuta_' ),
				'id'          => "home_banner",
				'type'        => 'checkbox',
				'value'		  => '1'
				),
			array(
				'name'        => __( 'É um card da home', 'batuta_' ),
				'id'          => "home_cards",
				'type'        => 'checkbox',
				'value'		  => '1'
				),
			)
		],
		[
		'id'         => 'its_pessoas',
		'title'      => __( 'Equipe, Palestrantes e Autores', 'batuta_' ),
		'post_types' => [ 'varandas_ctp', 'cursos_ctp','page', 'comunicados_ctp' ],
		'context'    => 'normal',
		'priority'   => 'high',
		'autosave'   => true,
		'fields'     => array(
			array(
				'name'        => __( 'Palestrantes e Autores', 'batuta_' ),
				'id'          => "its_pessoas",
				'type'        => 'select_advanced',
				'options'     => $pessoas,
				'multiple'    => true,
				'std'         => 'value2',
				'placeholder' => __( 'Selecione as pessoas', 'galeria_se' ),
				),
			)
		]
		);

	return $meta_boxes;
}
