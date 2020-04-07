<?php

	
function fca_pc_edd_rss_feed() {
	$options = get_option( 'fca_pc', array() );
	$post_count = wp_count_posts( 'download' )->publish;

	fca_pc_edd_do_feed_head();
	$pages = ceil( $post_count / 100 );
	for ( $i = 0; $i < $pages; $i++ ) {
		fca_pc_edd_do_feed_body( $options, $i );
	}
	fca_pc_edd_do_feed_footer();
	
}

function fca_pc_edd_do_feed_head() {
		
	echo "<?xml version='1.0'?>"; //PHP DOESNT LIKE <? IN THE XML
	ob_start(); ?>

	<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
		<channel>
			<title><?php echo bloginfo( 'name' ) ?></title>
			<link><?php echo site_url() ?></link>
			<description><?php bloginfo( 'description' ) ?></description>
	<?php echo ob_get_clean();
	
}

function fca_pc_edd_do_feed_footer() {
	ob_start(); ?>
		</channel>
	</rss><?php
	echo ob_get_clean();
}

function fca_pc_edd_is_excluded_download( $id, $excluded_product_cats ) {
	$cat_ids = array();
		
	$cats = get_the_terms( $id, 'download_category' );
	if ( $cats ) {
		$cat_ids = array_merge( $cats, $cat_ids );
	}
	$tags = get_the_terms( $id, 'download_tag' );
	if ( $tags ) {
		$cat_ids = array_merge( $tags, $cat_ids );
	}
	$cat_ids = array_map( 'fca_pc_term_id_fiter', $cat_ids );
	
	return count ( array_intersect( $cat_ids, $excluded_product_cats ) ) !== 0;
}

function fca_pc_edd_do_feed_body( $options, $offset = 0 ) {
	
	$search = array(
		'post_type' => 'download',
		'post_status' => 'publish',
		'posts_per_page' => 100,
		'offset' => 100 * $offset,
		'orderby' => 'ID',
		'order' => 'ASC'
	);
	
	$products = get_posts( $search );
	$desc_mode = empty( $options['edd_desc_mode'] ) ? 'content' : $options['edd_desc_mode'];
	$excluded_product_cats = empty( $options['edd_excluded_categories'] ) ? array() : $options['edd_excluded_categories'];	
	
	ob_start();
	forEach( $products as $p ) {
		$download = new EDD_Download( $p->ID ); 
			
		if ( !fca_pc_edd_is_excluded_download( $p->ID, $excluded_product_cats ) ) { 
		?>
		<item>
			<g:id><?php echo $p->ID ?></g:id>
			<g:title><?php echo fca_pc_edd_encode_xml( get_the_title( $p->ID ) ) ?></g:title>
			<g:description><?php echo $desc_mode === 'content' ? fca_pc_edd_encode_xml( $p->post_content ) : fca_pc_edd_encode_xml( get_the_excerpt( $p->ID ) ) ?></g:description>
			<g:link><?php echo get_permalink( $p->ID ) ?></g:link>
			<g:image_link><?php echo fca_pc_edd_product_image( $p->ID ) ?></g:image_link>
			<g:brand><?php echo fca_pc_edd_encode_xml( bloginfo( 'name' ) ) ?></g:brand>
<?php fca_pc_edd_maybe_add_cat( $p->ID ) ?>
			<g:condition>new</g:condition>
			<g:availability>in stock</g:availability>
			<g:price><?php fca_pc_edd_feed_price( $download ) ?></g:price>
			<g:google_product_category>5032</g:google_product_category>
		</item>
	<?php
		}
		clean_post_cache( $p->ID );
	}
	
	echo ob_get_clean();
}
function fca_pc_edd_maybe_add_cat( $id ) {
	$cats = get_the_terms( $id, 'download_category' );
	if ( $cats ) {
		echo "\t\t\t" . '<g:product_type>' .  fca_pc_edd_encode_xml( $cats[0]->name ) . '</g:product_type>';
	}
}

function fca_pc_edd_feed_price( $download ) {
	if ( $download->get_price() ) {
		echo $download->get_price() . ' ' . edd_get_option( 'currency', 'USD' );
	} else {
		echo '0';
	}
}

function fca_pc_edd_product_image( $post_id ) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
	$placeholder = plugins_url() . '/easy-digital-downloads/assets/images/edd-badge.png';
	$image = empty( $image[0] ) ? $placeholder : $image[0];
	return $image;
}

function fca_pc_edd_encode_xml( $string ) {
	return htmlspecialchars ( strip_tags ( $string ) );
}

function fca_pc_edd_add_feed(){
	$options = get_option( 'fca_pc', array() );
	
	if ( !empty( $options['edd_feed'] ) ) {
		add_feed( 'edd-pixelcat', 'fca_pc_edd_rss_feed' );	
	}
}
add_action('init', 'fca_pc_edd_add_feed');

function fca_pc_edd_feed_content_type( $content_type, $type ) {
	if ( 'edd-pixelcat' === $type ) {
		return feed_content_type( 'rss-http' );
	}
	return $content_type;
}
add_filter( 'feed_content_type', 'fca_pc_edd_feed_content_type', 10, 2 );

