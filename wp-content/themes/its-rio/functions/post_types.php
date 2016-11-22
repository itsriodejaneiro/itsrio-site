<?php

function custom_post_type() {
	register_custom_post_type('varandas_ctp','Varanda','Varandas', 'dashicons-store');
	register_custom_post_type('projetos_ctp','Projeto','Projetos', 'dashicons-portfolio');
	register_custom_post_type('cursos_ctp','Curso','Cursos', 'dashicons-book');
	register_custom_post_type('publicacoes_ctp','Publicação','Publicações','dashicons-book-alt');
	register_custom_post_type('pessoas','Pessoa','Pessoas', 'dashicons-welcome-learn-more', [ 'title', 'editor', 'thumbnail']);
}

function register_custom_post_type($id, $singular, $plural, $icon = 'dashicons-admin-post', $supports = [ 'title', 'editor', 'excerpt', 'author', 'thumbnail']) {
	$labels = array(
		'name'                  => _x( $plural, 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( $singular, 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( $plural, 'text_domain' ),
		'name_admin_bar'        => __( $plural, 'text_domain' ),
		'archives'              => __( 'Arquivos', 'text_domain' ),
		'parent_item_colon'     => __( 'Item pai:', 'text_domain' ),
		'all_items'             => __( 'Todos os Items', 'text_domain' ),
		'add_new_item'          => __( 'Adicionar '.$singular, 'text_domain' ),
		'add_new'               => __( 'Adicionar '.$singular, 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Editar '.$singular, 'text_domain' ),
		'update_item'           => __( 'Atualizar', 'text_domain' ),
		'view_item'             => __( 'Ver', 'text_domain' ),
		'search_items'          => __( 'Buscar', 'text_domain' ),
		'not_found'             => __( 'Não encontrado', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
		);
	$args = array(
		'label'                 => __( $singular, 'text_domain' ),
		'description'           => __( 'Post type de varandas', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => $supports,
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'   			=> $icon,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		);
	register_post_type($id, $args);
}

add_action( 'init', 'custom_post_type', 0 );