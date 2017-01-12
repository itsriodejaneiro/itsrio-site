<?php
/*
* $data para implantação de VueJS. Essa variável deve conter informações de aspectos globais.
* Para informações usadas internamente em componentes deve ser usada a $components.
*
* $data['its_tabs'] se refere aos módulos Divi adicionados
* que devem aparecer como abas no submenu das internas.
*
*/
setlocale(LC_ALL, 'pt_BR');
error_reporting(E_ERROR);
$lang = str_replace('-', '_', strtolower(get_bloginfo('language')));
$lang = $lang == 'pt_br' ? 'pt' : 'en';


$data = ['its_tabs' => [], 'single_menu_active' => '0', 'search' => [ 'title' => 'false' ], 'footer' => [ 'medium' => [], 'youtube' => [] ] ];
$components = [];

$title = '';
$titles = '';
$postType;

define('ROOT',__DIR__.'/');
define('YOUTUBE_KEY', 'AIzaSyCiKcRsuOdRuo0qWGR6n09UdiCiz5A4uzY');
define('YOUTUBE_ID', 'UC61OfX5yfm-G8O1sZ7TKlGQ');

include 'functions/post_types.php';
include 'functions/meta.php';
include 'functions/ajax-calls.php';
include 'functions/components/components.php';
include 'functions/enqueued_scripts.php';
include 'functions/menu-footer.php';
include 'functions/menu-map.php';

function wpdocs_custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

add_theme_support( 'post-thumbnails' );

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

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

function get_thumbnail_url_full($id){
	return wp_get_attachment_image_src(get_post_thumbnail_id($id),'full')[0];
}

function get_thumbnail_url_card($id){
	global $dynamic_featured_image;
	$images = $dynamic_featured_image->get_featured_images($id);

	if(empty($images) || !isset($images[0]))
		return get_thumbnail_url_full($id);

	return $dynamic_featured_image->get_featured_images($id)[0]['full'];
}

function get_thumbnail_url_banner($id){
	global $dynamic_featured_image;
	$images = $dynamic_featured_image->get_featured_images($id);

	if(empty($images) || !isset($images[0]))
		return get_thumbnail_url_full($id);

	return $dynamic_featured_image->get_featured_images($id)[1]['full'];
}

function get_thumbnail_style($id, $size){
	$fun = 'get_thumbnail_url_'.$size;
	$url = $fun($id);

	return ' style="background-image:url(\''.$url.'\')" ';
}

function curl($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

function str_replace_first($from, $to, $subject)
{
	$from = '/'.preg_quote($from, '/').'/';

	return preg_replace($from, $to, $subject, 1);
}


function limit_excerpt($s, $max_length){
	if (strlen($s) > $max_length)
	{
		$offset = ($max_length - 3) - strlen($s);
		$s = substr($s, 0, strrpos($s, ' ', $offset)) . '...';
	}

	return $s;
}

function get_area_pesquisa(){
	global $meta;
	$i = $meta['info_areapesquisa'][0];
	$a = ['Direitos e tecnologia', 'Repensando Inovação', 'Democracia e Tecnologia','Educação'];
	return $a[$i];
}

function clear_divi_cache($hook){
	global $post;
	if ($hook == 'post-new.php' || $hook == 'post.php') {
		if ('pessoas' === $post->post_type ) {
			echo "<script>window.localStorage.clear();</script>";
		}
	}
}
add_action('admin_enqueue_scripts', 'clear_divi_cache');

// Removes from admin menu
add_action( 'admin_menu', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
	remove_menu_page( 'edit-comments.php' );
}
// Removes from post and pages
add_action('init', 'remove_comment_support', 100);

function remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}


// Removes from admin bar
function mytheme_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );


add_filter( 'gettext', 'wpse22764_gettext', 10, 2 );
function wpse22764_gettext( $translation, $original )
{
	if ( 'Excerpt' == $original )
		return 'Subtítulo';

	return $translation;
}

//PARA A TELA DE BUSCA
add_filter( 'posts_where', 'LIKE_posts_where', 10, 2 );
function LIKE_posts_where( $where, &$wp_query )
{
	global $wpdb;
	if ( $title_like = $wp_query->get( 'title_like' ) ) {
		$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $title_like ) ) . '%\'';
	}
	return $where;
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
