<?php

add_filter( 'rwmb_meta_boxes', 'its_meta_boxes' );

function its_meta_boxes($meta_boxes) {
	$publicacoes = get_ctp_array('publicacoes_ctp');
	$pessoas = get_ctp_array('pessoas');
	$areas = get_ctp_array('areas');

	// ['Direitos e tecnologia', 'Repensando Inovação', 'Democracia e Tecnologia','Educação'],

	$meta_boxes = array([
		'id'		=> 'projetoencerrado',
		'title'     => __('Informações do Projeto', 'textdomain' ),
		'post_types'=> ['projetos_ctp'],
		'fields'    => array(
			['id'	=> "projeto_encerrado", 'name' => 'Este projeto está encerrado?', 'type' => 'checkbox', 'value' => '1'],
			),
		],
		['id'		=> 'infosss',
		'title'     => __('Informações', 'textdomain' ),
		'post_types'=> ['publicacoes_ctp'],
		'fields'    => array(
			['id'   => 'pt_pdf', 'name' => __('URL do arquivo PDF', 'textdomain'), 'type' => 'text'],
			['id'   => 'en_pdf', 'name' => __('URL do arquivo PDF (ingês)', 'textdomain'), 'type' => 'text'],
			['id'	=> "publi_banner", 'name' => 'É um destaque da intermediária de Publicações?', 'type' => 'checkbox', 'value' => '1'],
			['id'	=> "datapubli", 'name' => 'Data de Publicação', 'type' => 'checkbox', 'value' => '1'],
			),
		],
		[
		'title'      => __('Área de Pesquisa', 'textdomain' ),
		'post_types' => ['projetos_ctp','publicacoes_ctp'],
		'fields'     => array(
			[
			'id'   => 'info_areapesquisa',
			'name' => __('Área de Pesquisa', 'textdomain'),
			'type'        => 'select',
			'options'     => $areas,
			]
			),
		],
		[
		'title'      => __('Informações de Datas', 'textdomain' ),
		'post_types' => ['varandas_ctp','cursos_ctp'],
		'fields'     => array(
			['id'   => 'info_inscinicio', 'name' => __('Início das Inscrições', 'textdomain'), 'type' => 'date'],
			['id'   => 'info_inscfim', 'name' => __('Fim das Inscrições', 'textdomain'), 'type' => 'date'],
			['id'   => 'info_data', 'name' => __('Data da Varanda', 'textdomain'), 'type' => 'date'],
			['id'   => 'info_hora', 'name' => __('Horário da Varanda', 'textdomain'), 'type' => 'text'],
			)
		],
		[
		'title'      => __('Typeform para Inscrições', 'textdomain' ),
		'post_types' => ['varandas_ctp','cursos_ctp'],
		'fields'     => array(
			['id'   => 'typeform_url', 'name' => __('URL do Typeform', 'textdomain'), 'type' => 'text'],
			['id'   => 'typeform_layout', 'name' => __('Formato do form', 'textdomain'), 'type' => 'radio', 'options' => [ '2'=> 'Lateral', '1' => 'Tela cheia' ]],
			)
		],
		[
		'title'      => __('Valores', 'textdomain' ),
		'post_types' => ['cursos_ctp'],
		'fields'     => array(
			['id'   => 'info_valor', 'name' => __('Coluna com informações de valor', 'textdomain'), 'type' => 'wysiwyg'],
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
		'post_types' => [ 'varandas_ctp', 'cursos_ctp','comunicados_ctp', 'publicacoes_ctp', 'projetos_ctp' ],
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
		'post_types' => [ 'varandas_ctp', 'cursos_ctp','page', 'comunicados_ctp', 'publicacoes_ctp' ],
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
