<?php


function fca_pc_woo_rss_feed() {
	$options = get_option( 'fca_pc', array() );
	$post_count = wp_count_posts( 'product' )->publish;

	fca_pc_do_feed_head();
	$pages = ceil( $post_count / 100 );
	for ( $i = 0; $i < $pages; $i++ ) {
		fca_pc_do_feed_body( $options, $i );
	}
	fca_pc_do_feed_footer();

}

function fca_pc_do_feed_head() {

	echo "<?xml version='1.0'?>"; //PHP DOESNT LIKE <? IN THE XML
	ob_start(); ?>

	<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
		<channel>
			<title><?php echo bloginfo( 'name' ) ?></title>
			<link><?php echo site_url() ?></link>
			<description><?php bloginfo( 'description' ) ?></description>
	<?php echo ob_get_clean();

}

function fca_pc_do_feed_footer() {
	ob_start(); ?>
		</channel>
	</rss><?php
	echo ob_get_clean();
}

function fca_pc_do_feed_body( $options, $offset = 0 ) {

	$search = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => 100,
		'offset' => 100 * $offset,
		'orderby' => 'ID',
		'order' => 'ASC'
	);

	$products = get_posts( $search );

	$excluded_product_cats = empty( $options['woo_excluded_categories'] ) ? array() : $options['woo_excluded_categories'];

	ob_start();
	forEach( $products as $p ) {

		$wc_product = wc_get_product( $p->ID );

		//CHECK FOR EXCLUDED CATEGORIES
		$cat_ids = array_merge( $wc_product->get_category_ids(), $wc_product->get_tag_ids() );

		if ( count ( array_intersect( $cat_ids, $excluded_product_cats ) ) !== 0 ) {
			continue;
		}
		
		fca_pc_woo_feed_item( $wc_product, $options );
		
		clean_post_cache( $p->ID );
	}

	echo ob_get_clean();
}

function fca_pc_woo_feed_item( $wc_product, $options ) {

	$woo_id_mode = empty( $options['woo_product_id'] ) ? 'post_id' : $options['woo_product_id'];
	$product_id = $woo_id_mode === 'post_id' ? $wc_product->get_id() : $wc_product->get_sku();
	$woo_desc_mode = empty( $options['woo_desc_mode'] ) ? 'description' : $options['woo_desc_mode'];
	$description =  $woo_desc_mode == 'description' ? $wc_product->get_description() : $wc_product->get_short_description();
	if ( empty( $description ) ) {
		$description = __('Description is not available.', 'fca_pc');	
	}	
	$product_link = $wc_product->get_permalink();
	$product_image = fca_pc_woo_product_image( $wc_product->get_id() );

	//ADD VARIABLE PRODUCT AS SEPARATE PRODUCTS IN THE FEED
	if( $wc_product->is_type( 'variable' ) ) {
		forEach ( $wc_product->get_available_variations() as $variation ) {
			$title = $wc_product->get_title() . ' ' . fca_pc_expand_product_title( $variation[ 'attributes' ] );
			$product_image = fca_pc_woo_product_image( $wc_product->get_id(), $variation );
?>
<item>
	<g:id><?php echo $product_id . '-' . $variation[ 'variation_id' ] ?></g:id>
	<g:item_group_id><?php echo $product_id ?></g:item_group_id>
	<g:title><?php echo fca_pc_encode_xml( $title ) ?></g:title>
	<g:description><?php echo fca_pc_encode_xml( $description ) ?></g:description>
	<g:link><?php echo fca_pc_encode_xml( $product_link ) ?></g:link>
	<g:image_link><?php echo fca_pc_encode_xml( $product_image ) ?></g:image_link>
	<?php fca_pc_woo_feed_brand( $wc_product ) ?>
	<g:condition><?php fca_pc_woo_feed_condition( $wc_product ) ?></g:condition>
	<g:availability><?php echo $wc_product->is_in_stock() ? 'in stock' : 'out of stock' ?></g:availability>
	<g:price><?php fca_pc_woo_feed_price( $wc_product, $variation ) ?></g:price>
	<?php fca_pc_woo_feed_extra_fields( $wc_product, $variation[ 'attributes' ] ) ?>
	<?php fca_pc_woo_feed_additional_images( $wc_product, $product_image, $variation ) ?>
	<?php fca_pc_woo_feed_google_product_cateogry( $wc_product, $options ) ?>	
</item>
<?php			
		}

	} else { 
	
?>
<item>
	<g:id><?php echo $product_id ?></g:id>
	<g:title><?php echo fca_pc_encode_xml( $wc_product->get_title() ) ?></g:title>
	<g:description><?php echo fca_pc_encode_xml( $description ) ?></g:description>
	<g:link><?php echo fca_pc_encode_xml( $product_link ) ?></g:link>
	<g:image_link><?php echo fca_pc_encode_xml( $product_image ) ?></g:image_link>
	<?php fca_pc_woo_feed_brand( $wc_product ) ?>
	<g:condition><?php fca_pc_woo_feed_condition( $wc_product ) ?></g:condition>
	<g:availability><?php echo $wc_product->is_in_stock() ? 'in stock' : 'out of stock' ?></g:availability>
	<g:price><?php fca_pc_woo_feed_price( $wc_product ) ?></g:price>
	<?php fca_pc_woo_feed_extra_fields( $wc_product ) ?>
	<?php fca_pc_woo_feed_additional_images( $wc_product, $product_image ) ?>
	<?php fca_pc_woo_feed_google_product_cateogry( $wc_product, $options ) ?>
</item><?php

	}	
}

function fca_pc_woo_feed_price( $wc_product, $variation = null ) {
	$the_price = is_array( $variation ) ? $variation[ 'display_price' ] : wc_get_price_to_display( $wc_product );

	if ( $the_price ) {
		echo $the_price . ' ' . get_woocommerce_currency();
	} else {
		echo '0';
	}
}

function fca_pc_woo_feed_condition( $wc_product ) {
	if ( $wc_product->get_attribute('condition') ) {
		echo fca_pc_encode_xml( $wc_product->get_attribute('condition') );
	} else {
		echo 'new';
	}
}

function fca_pc_woo_feed_brand( $wc_product ) {
	if ( $wc_product->get_attribute('gtin') ) {
		echo '<g:gtin>' . fca_pc_encode_xml( $wc_product->get_attribute('gtin') ) . "</g:gtin>\n";
	} else if ( $wc_product->get_attribute('mpn') ) {
		echo '<g:mpn>' . fca_pc_encode_xml( $wc_product->get_attribute('mpn') ) . "</g:mpn>\n";
	} else if ( $wc_product->get_attribute('brand') ) {
		echo '<g:brand>' . fca_pc_encode_xml( $wc_product->get_attribute('brand') ) . "</g:brand>\n";
	} else {
		echo '<g:brand>';
		fca_pc_encode_xml( bloginfo( 'name' ) );
		echo "</g:brand>\n";
	}
}

function fca_pc_woo_product_image( $post_id, $variation = null ) {
	$media_id = is_array( $variation ) ? $variation[ 'image_id' ] : get_post_thumbnail_id( $post_id );
	$image = wp_get_attachment_image_src( $media_id, 'single-post-thumbnail' );
	$placeholder = plugins_url() . '/woocommerce/assets/images/placeholder.png';
	$image = empty( $image[0] ) ? $placeholder : $image[0];
	return $image;
}

function fca_pc_woo_feed_extra_fields( $wc_product, $attributes = null ) {
	$extra_fields = array(
		'color',
		'gender',
		'pattern',
		'material',
		'size'
	);

	forEach ( $extra_fields as $field ) {
		if ( isSet( $attributes[ 'attribute_pa_' . $field ] ) ) {
			echo "\t<$field>" . fca_pc_encode_xml( $attributes[ 'attribute_pa_' . $field ] ) . "</$field>\n";
		} else if ( $wc_product->get_attribute( $field ) ) {
			echo "\t<$field>" . fca_pc_encode_xml( $wc_product->get_attribute( $field ) ) . "</$field>\n";
		}
	}
}

function fca_pc_woo_feed_google_product_cateogry( $wc_product, $options ) {
	
	$google_product_category = empty( $options['google_product_category'] ) ? $wc_product->get_attribute( 'google_product_category' ) : $options['google_product_category'];
	
	if ( $google_product_category ) {
		echo '<g:google_product_category>' . fca_pc_encode_xml( $google_product_category ) . "</g:google_product_category>\n";
	}
}

function fca_pc_encode_xml( $string ) {

	return htmlspecialchars( strip_tags ( $string ) );
}

function fca_pc_add_woo_rss_feed(){
	$options = get_option( 'fca_pc', 'no options' );

	if ( !empty( $options['woo_feed'] ) ) {
		add_feed( 'pixelcat', 'fca_pc_woo_rss_feed' );
	}
}
add_action('init', 'fca_pc_add_woo_rss_feed');

function fca_pc_woo_feed_content_type( $content_type, $type ) {
	if ( 'pixelcat' === $type ) {
		return feed_content_type( 'rss-http' );
	}
	return $content_type;
}
add_filter( 'feed_content_type', 'fca_pc_woo_feed_content_type', 10, 2 );

function fca_pc_expand_product_title( $variations ) {

	if ( is_array( $variations ) ) {

		$variation_values = array();

		foreach ( $variations as $key => $value ) {
			$variation_values[] = $value;
		}

		return '(' . implode( '-', $variation_values ) . ')';

	}

	return '';

}
function fca_pc_woo_feed_additional_images( $wc_product, $default_image, $variation = null ) {
	
	forEach ( fca_pc_get_additional_image_url( $wc_product, $variation ) as $image_url ) {
		if ( $image_url && $image_url !== $default_image ) {
			echo "\t<additional_image_link>". fca_pc_encode_xml( $image_url ) . "</additional_image_link>\n";
		}
	}
}

function fca_pc_get_additional_image_url( $product, $variation = null ) {

	$images = array();

	if ( is_array( $variation ) ) {
		$variation_image = wp_get_attachment_image_src( $variation[ 'image_id' ], 'single-post-thumbnail' );

		if ( !empty( $variation_image ) ) {
			$images[] = $variation_image[0];
		}
	}

	$gallery_ids = $product->get_gallery_image_ids();

	if ( !empty( $gallery_ids ) ) {
		foreach ($gallery_ids as $attachment_id) {
			$images[] = wp_get_attachment_url( $attachment_id );
		}
	}

	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' );

	if ( !empty( $featured_image ) ) {
		$images[] = $featured_image[0];
	}

	$images = array_unique( $images );

	return $images;

}