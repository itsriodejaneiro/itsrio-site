<?php
// Register Custom Taxonomy



add_action( 'init', 'custom_taxonomy', 0 );

function custom_taxonomy(){
    register_custom_taxonomy('videos_ctp_cat', 'videos_ctp', 'Categoria de vídeo', 'Categoria de vídeos', "Categorias de vídeos");
    register_custom_taxonomy('artigos_ctp_cat', 'artigos_ctp', 'Categoria de Artigo', 'Categoria de artigos', "Categorias de artigos");
    register_custom_taxonomy('publicacoes_ctp_cat', 'publicacoes_ctp', 'Categoria de publicação', 'Categoria de publicações', "Categorias de publicações");
    register_custom_taxonomy('comunicados_ctp_cat', 'comunicados_ctp', 'Categoria de comunicado', 'Categorias de comunicados', "Categorias de comunicados");
}
function register_custom_taxonomy($tx_slug, $tx_post_type, $tx_name, $tx_singular, $tx_plural) {

	$labels = array(
		'name'                       => _x( $tx_plural, 'Taxonomy General Name', 'itsrio' ),
		'singular_name'              => _x( $tx_singular, 'Taxonomy Singular Name', 'itsrio' ),
		'menu_name'                  => __( $tx_name, 'itsrio' ),
		'all_items'                  => __( 'Todos os itens', 'itsrio' ),
		'parent_item'                => __( 'Item pai', 'itsrio' ),
		'parent_item_colon'          => __( 'Item pai:', 'itsrio' ),
		'new_item_name'              => __( 'Adicionar '.$tx_singular, 'itsrio' ),
		'add_new_item'               => __( 'Adicionar '.$tx_singular, 'itsrio' ),
		'edit_item'                  => __( 'Editar '. $tx_singular, 'itsrio' ),
		'update_item'                => __( 'Atualizar ' .$tx_singular, 'itsrio' ),
		'view_item'                  => __( 'Ver '. $tx_singular, 'itsrio' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'itsrio' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'itsrio' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'itsrio' ),
		'popular_items'              => __( 'Popular Items', 'itsrio' ),
		'search_items'               => __( 'Search Items', 'itsrio' ),
		'not_found'                  => __( 'Not Found', 'itsrio' ),
		'no_terms'                   => __( 'No items', 'itsrio' ),
		'items_list'                 => __( 'Items list', 'itsrio' ),
		'items_list_navigation'      => __( 'Items list navigation', 'itsrio' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( $tx_slug, array( $tx_post_type ), $args );

}
