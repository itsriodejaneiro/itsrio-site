<?php
/*
Plugin Name: ITS-RIO
Plugin URI:
Description:
Author:
Version:
Author URI:
*/


// Register Style
function its_ctm_css() {

	wp_enqueue_style( 'its', esc_url_raw('/wp-content/plugins/its-rio/assets/css/its.css'), array(), null );
	wp_enqueue_style( 'foundation', esc_url_raw('/wp-content/plugins/its-rio/assets/css/foundation.min.css'), array(), null );


}
add_action( 'wp_enqueue_scripts', 'its_ctm_css' );



function my_et_builder_post_types( $post_types ) {
	$post_types[] = 'varandas_ctp';
	$post_types[] = 'projetos_ctp';
	$post_types[] = 'cursos_ctp';
	$post_types[] = 'publicacoes_ctp';


	return $post_types;
}
add_filter( 'et_builder_post_types', 'my_et_builder_post_types' );


// Register Custom Post Type
function custom_post_type()
{
	register_custom_post_type('varandas_ctp','Varanda','Varandas');
	register_custom_post_type('projetos_ctp','Projeto','Projetos');
	register_custom_post_type('cursos_ctp','Curso','Cursos');
	register_custom_post_type('publicacoes_ctp','Publicação','Publicações');
}

function register_custom_post_type($id, $singular, $plural, $supports = [ 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields']) {

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
		'menu_position'         => rand(0,5),
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		);
	register_post_type($id, $args );

}



add_action( 'init', 'custom_post_type', 0 );


function DS_Custom_Modules(){
	if(class_exists("ET_Builder_Module")){
		include("components/latest_posts/its_lastest_post.php");
		include("components/submenu/its_submenu.php");
	}
}

function Prep_DS_Custom_Modules(){
	global $pagenow;

	$is_admin = is_admin();
	$action_hook = $is_admin ? 'wp_loaded' : 'wp';
	$required_admin_pages = array( 'edit.php', 'post.php', 'post-new.php', 'admin.php', 'customize.php', 'edit-tags.php', 'admin-ajax.php', 'export.php' );
	$specific_filter_pages = array( 'edit.php', 'admin.php', 'edit-tags.php' );
	$is_edit_library_page = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'et_pb_layout' === $_GET['post_type'];
	$is_role_editor_page = 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'et_divi_role_editor' === $_GET['page'];
	$is_import_page = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import'];
	$is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];

	if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
		add_action($action_hook, 'DS_Custom_Modules', 9789);
	}
}


Prep_DS_Custom_Modules();



function dd($a)
{
	var_dump($a);
	die;
}

add_filter( 'rwmb_meta_boxes', 'your_prefix_meta_boxes' );
function your_prefix_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'      => __( 'Test Meta Box', 'textdomain' ),
        'post_types' => 'cursos_ctp',
        'fields'     => array(
            array(
                'id'   => 'name',
                'name' => __( 'Name', 'textdomain' ),
                'type' => 'text',
            ),
            array(
                'id'      => 'gender',
                'name'    => __( 'Gender', 'textdomain' ),
                'type'    => 'radio',
                'options' => array(
                    'm' => __( 'Male', 'textdomain' ),
                    'f' => __( 'Female', 'textdomain' ),
                ),
            ),
            array(
                'id'   => 'email',
                'name' => __( 'Email', 'textdomain' ),
                'type' => 'email',
            ),
            array(
                'id'   => 'bio',
                'name' => __( 'Biography', 'textdomain' ),
                'type' => 'textarea',
            ),
        ),
    );
    return $meta_boxes;
}



add_filter( 'rwmb_meta_boxes', 'your_prefix_map_demo' );
function your_prefix_map_demo( $meta_boxes ) {
	$meta_boxes[] = array(
		'title'  => __( 'Google Map', 'your-prefix' ),
        'post_types' => 'cursos_ctp',
		'fields' => array(
			// Map requires at least one address field (with type = text)
			array(
				'id'   => 'address',
				'name' => __( 'Endereço', 'your-prefix' ),
				'type' => 'text',
				'std'  => __( 'São Paulo, Brasil', 'your-prefix' ),
			),
			array(
				'id'            => 'map',
				'name'          => __( 'Local', 'your-prefix' ),
				'type'          => 'map',
				// Default location: 'latitude,longitude[,zoom]' (zoom is optional)
				'std'           => '-6.233406,-35.049906,15',
				// Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
				'address_field' => 'address',
				'api_key'       => 'AIzaSyBfjsyakP5UtWJnUJuvY3uPPOUIMCa9DOg', // https://metabox.io/docs/define-fields/#section-map
			),
		),
	);
	return $meta_boxes;
}