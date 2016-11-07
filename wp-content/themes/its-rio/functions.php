<?php
/* $data para implantação de vuejs ou angular */
$data = '';
$aulas = [];

add_theme_support( 'post-thumbnails' );

include 'functions/enqueued_scripts.php';
include 'functions/post_types.php';
include 'functions/meta.php';
include 'functions/components/components.php';

function get_post_number($postID){
	$postNumberQuery = new WP_Query(array ( 'orderby' => 'date', 'order' => 'ASC', 'post_type' => 'any','posts_per_page' => '-1' ));
	$counter = 1;
	$postCount = 0;
	if($postNumberQuery->have_posts()) :
		while ($postNumberQuery->have_posts()) : $postNumberQuery->the_post();
	if ($postID == get_the_ID()){
		$postCount = $counter;
	} else {
		$counter++;
	}
	endwhile; endif;
	wp_reset_query();
	return (int)$postCount < 10 ? '0'.$postCount : $postCount;
}





























// add_filter( 'rwmb_meta_boxes', 'your_prefix_meta_boxes' );
// function your_prefix_meta_boxes( $meta_boxes ) {
// 	$meta_boxes[] = array(
// 		'title'      => __( 'Test Meta Box', 'textdomain' ),
// 		'post_types' => 'cursos_ctp',
// 		'fields'     => array(
// 			array(
// 				'id'   => 'name',
// 				'name' => __( 'Name', 'textdomain' ),
// 				'type' => 'text',
// 				),
// 			),
// 		);
// 	return $meta_boxes;
// }

// add_filter( 'rwmb_meta_boxes', 'your_prefix_map_demo' );
// function your_prefix_map_demo( $meta_boxes ) {
// 	$meta_boxes[] = array(
// 		'title'  => __( 'Google Map', 'your-prefix' ),
// 		'post_types' => 'cursos_ctp',
// 		'fields' => array(
// 			// Map requires at least one address field (with type = text)
// 			array(
// 				'id'   => 'address',
// 				'name' => __( 'Endereço', 'your-prefix' ),
// 				'type' => 'text',
// 				'std'  => __( 'São Paulo, Brasil', 'your-prefix' ),
// 				),
// 			array(
// 				'id'            => 'map',
// 				'name'          => __( 'Local', 'your-prefix' ),
// 				'type'          => 'map',
// 				// Default location: 'latitude,longitude[,zoom]' (zoom is optional)
// 				'std'           => '-6.233406,-35.049906,15',
// 				// Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
// 				'address_field' => 'address',
// 				'api_key'       => 'AIzaSyBfjsyakP5UtWJnUJuvY3uPPOUIMCa9DOg', // https://metabox.io/docs/define-fields/#section-map
// 				),
// 			),
// 		);
// 	return $meta_boxes;
// }

// function my_et_builder_post_types( $post_types ) {
// 	$post_types[] = 'varandas_ctp';
// 	// $post_types[] = 'projetos_ctp';
// 	$post_types[] = 'cursos_ctp';
// 	$post_types[] = 'publicacoes_ctp';


// 	return $post_types;
// }
// add_filter( 'et_builder_post_types', 'my_et_builder_post_types' );

// Register Custom Taxonomy
// function custom_taxonomy() {

// 	$labels = array(
// 		'name'                       => _x( 'Palestrante', 'Taxonomy General Name', 'text_domain' ),
// 		'singular_name'              => _x( 'Palestrante', 'Taxonomy Singular Name', 'text_domain' ),
// 		'menu_name'                  => __( 'Palestrante', 'text_domain' ),
// 		'all_items'                  => __( 'All Items', 'text_domain' ),
// 		'parent_item'                => __( 'Parent Item', 'text_domain' ),
// 		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
// 		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
// 		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
// 		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
// 		'update_item'                => __( 'Update Item', 'text_domain' ),
// 		'view_item'                  => __( 'View Item', 'text_domain' ),
// 		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
// 		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
// 		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
// 		'popular_items'              => __( 'Popular Items', 'text_domain' ),
// 		'search_items'               => __( 'Search Items', 'text_domain' ),
// 		'not_found'                  => __( 'Not Found', 'text_domain' ),
// 		'no_terms'                   => __( 'No items', 'text_domain' ),
// 		'items_list'                 => __( 'Items list', 'text_domain' ),
// 		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
// 		);
// 	$args = array(
// 		'labels'                     => $labels,
// 		'hierarchical'               => false,
// 		'public'                     => true,
// 		'show_ui'                    => true,
// 		'show_admin_column'          => true,
// 		'show_in_nav_menus'          => true,
// 		'show_tagcloud'              => true,
// 		);
// 	register_taxonomy( 'palestrantes', array( 'cursos_ctp' ), $args );

// }
// add_action( 'init', 'custom_taxonomy', 0 );
