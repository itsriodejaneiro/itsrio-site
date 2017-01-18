<?php 
// add_action( 'wp_enqueue_scripts', 'secure_enqueue_script' );
// function secure_enqueue_script() {
//     wp_register_script( 'secure-ajax-access', esc_url( add_query_arg( array( 'js_global' => 1 ), site_url() ) ) );
//     wp_enqueue_script( 'secure-ajax-access' );
// }

// add_action( 'template_redirect', 'javascript_variaveis' );
// function javascript_variaveis() {
//     if ( !isset( $_GET[ 'js_global' ] ) ) return;

//     $nonce = wp_create_nonce('search_categories_nonce');

//     $variaveis_javascript = array(
//         'search_categories_nonce' => $nonce, 
//         'xhr_url' => admin_url('admin-ajax.php') 
//         );

//     $new_array = array();
//     foreach( $variaveis_javascript as $var => $value ) $new_array[] = esc_js( $var ) . " : '" . esc_js( $value ) . "'";

//     header("Content-type: application/x-javascript");
//     printf('var %s = {%s};', 'js_global', implode( ',', $new_array ) );
//     exit;
// }

// add_action('wp_ajax_nopriv_search_categories', 'search_categories');
// add_action('wp_ajax_search_categories', 'search_categories');

// function search_categories() {
//     if( ! wp_verify_nonce( $_POST['search_categories_nonce'], 'search_categories_nonce' ) ) {
//         echo '401'; 
//         die();
//     }


//     $terms = get_terms();
//     $return = [];
//     foreach ( $terms as $term ) {
//         if($term->taxonomy == 'category')
//             $return[$term->term_id] = $term->name;    
//     }
    
//     echo json_encode($return);

//     exit;
// }
