<?php

setlocale(LC_ALL, 'pt_BR');
error_reporting(0);
$lang = str_replace('-', '_', strtolower(get_bloginfo('language')));
$lang = $lang == 'pt_br' ? 'pt' : 'en';


$data = ['its_tabs' => [], 'single_menu_active' => '0', 'search' => [ 'title' => 'false' ], 'footer' => [ 'medium' => [], 'youtube' => [] ] ];
$components = [];

$title = '';
$titles = '';
$styles = '';
$postType;

define('ROOT', __DIR__.'/');
define('YOUTUBE_KEY', 'AIzaSyCiKcRsuOdRuo0qWGR6n09UdiCiz5A4uzY');
define('YOUTUBE_ID', 'UC61OfX5yfm-G8O1sZ7TKlGQ');

include 'functions/post_types.php';
include 'functions/meta.php';
include 'functions/ajax-calls.php';
include 'functions/components/components.php';
include 'functions/enqueued_scripts.php';
include 'functions/menu-footer.php';
include 'functions/menu-map.php';
include 'functions/translations.php';

function wpdocs_custom_excerpt_length($length)
{
    return 30;
}
add_filter('excerpt_length', 'wpdocs_custom_excerpt_length', 999);

add_theme_support('post-thumbnails');

@ini_set('upload_max_size', '64M');
@ini_set('post_max_size', '64M');
@ini_set('max_execution_time', '300000');

function get_post_number($postID)
{
    $postNumberQuery = new WP_Query(array( 'orderby' => 'date', 'order' => 'ASC', 'post_type' => 'any','posts_per_page' => '-1' ));
    $counter = 1;
    $postCount = 0;
    if ($postNumberQuery->have_posts()) :
        while ($postNumberQuery->have_posts()) : $postNumberQuery->the_post();
    if ($postID == get_the_ID()) {
        $postCount = $counter;
    } else {
        $counter++;
    }
    endwhile;
    endif;
    wp_reset_query();
    return (int)$postCount < 10 ? '0'.$postCount : $postCount;
}

function get_thumbnail_url_full($id)
{
    return wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full')[0];
}

function get_thumbnail_url_card($id)
{
    global $dynamic_featured_image;
    $images = $dynamic_featured_image->get_featured_images($id);

    if (empty($images) || !isset($images[0])) {
        return get_thumbnail_url_full($id);
    }

    return $dynamic_featured_image->get_featured_images($id)[0]['full'];
}

function get_thumbnail_url_banner($id)
{
    global $dynamic_featured_image;
    $images = $dynamic_featured_image->get_featured_images($id);

    if (empty($images) || !isset($images[0])) {
        return get_thumbnail_url_full($id);
    }

    return $dynamic_featured_image->get_featured_images($id)[1]['full'];
}

function get_thumbnail_style($id, $size)
{
    $fun = 'get_thumbnail_url_'.$size;
    $url = $fun($id);

    return ' style="background-image:url(\''.$url.'\')" ';
}

function curl($url)
{
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


function limit_excerpt($s, $max_length)
{
    if (strlen($s) > $max_length) {
        $offset = ($max_length - 3) - strlen($s);
        $s = substr($s, 0, strrpos($s, ' ', $offset)) . '...';
    }

    return $s;
}

function get_area_pesquisa($meta = null)
{
    global $lang;
    if (is_null($meta)) {
        global $meta;
    }
    $i = $meta['info_areapesquisa'][0];
    $title = get_ctp_array('areas')[$i];
    return "<a href='/$lang/projetos/#".sanitize_title($title)."'>".$title."</a>";
}

//Retorna um array simples de relação [ id => título ]
function get_ctp_array($post_type, $full = false, $order = [ 'orderby' => 'title', 'order' => 'ASC'])
{
    global $lang;
    $args = array_merge(['post_type' => $post_type, 'lang' => pll_current_language(), 'posts_per_page' => -1], $order);
    $query = get_posts($args);

    foreach ($query as $posta) {
        $posta = (array)$posta;
        $array[$posta['ID']]= $full ? $posta : $posta['post_title'];
    }
    return $array;
}

function clear_divi_cache($hook)
{
    global $post;
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if ('pessoas' === $post->post_type) {
            echo "<script>window.localStorage.clear();</script>";
        }
    }
}
add_action('admin_enqueue_scripts', 'clear_divi_cache');

// Removes from admin menu
add_action('admin_menu', 'my_remove_admin_menus');
function my_remove_admin_menus()
{
    remove_menu_page('edit-comments.php');
}
// Removes from post and pages
add_action('init', 'remove_comment_support', 100);

function remove_comment_support()
{
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
}

// Removes from admin bar
function mytheme_admin_bar_render()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'mytheme_admin_bar_render');


add_filter('gettext', 'wpse22764_gettext', 10, 2);
function wpse22764_gettext($translation, $original)
{
    if ('Excerpt' == $original) {
        return 'Subtítulo';
    }

    return $translation;
}

//PARA A TELA DE BUSCA
add_filter('posts_where', 'LIKE_posts_where', 10, 2);
function LIKE_posts_where($where, &$wp_query)
{
    global $wpdb;
    if ($title_like = $wp_query->get('title_like')) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($wpdb->esc_like($title_like)) . '%\'';
    }
    return $where;
}


function df_terms_clauses( $clauses, $taxonomy, $args ) {
    if ( isset( $args['post_type'] ) && ! empty( $args['post_type'] ) && $args['fields'] !== 'count' ) {
        global $wpdb;

        $post_types = array();

        if ( is_array( $args['post_type'] ) ) {
            foreach ( $args['post_type'] as $cpt ) {
                $post_types[] = "'" . $cpt . "'";
            }
        } else {
            $post_types[] = "'" . $args['post_type'] . "'";
        }

        if ( ! empty( $post_types ) ) {
            $clauses['fields'] = 'DISTINCT ' . str_replace( 'tt.*', 'tt.term_taxonomy_id, tt.taxonomy, tt.description, tt.parent', $clauses['fields'] ) . ', COUNT(p.post_type) AS count';
            $clauses['join'] .= ' LEFT JOIN ' . $wpdb->term_relationships . ' AS r ON r.term_taxonomy_id = tt.term_taxonomy_id LEFT JOIN ' . $wpdb->posts . ' AS p ON p.ID = r.object_id';
            $clauses['where'] .= ' AND (p.post_type IN (' . implode( ',', $post_types ) . ') OR p.post_type IS NULL)';
            $clauses['orderby'] = 'GROUP BY t.term_id ' . $clauses['orderby'];
        }
    }
    return $clauses;
}

add_filter( 'terms_clauses', 'df_terms_clauses', 10, 3 );

//Remove as páginas de categorias do google
function generate_robots_txt( $post_id ) {
    $terms = get_terms('category');
    $txt = 'User-agent: *
Disallow: /wp-admin';
    foreach ($terms as $term) {
        $txt .='
Disallow: /pt/category/'.$term->slug.'
Disallow: /en/category/'.$term->slug;
    }
    file_put_contents(ROOT.'robots.txt', $txt);
}
add_action( 'save_post', 'generate_robots_txt' );