<?php
 
function fca_pc_edd_event_search() {

	$options = get_option( 'fca_pc' );

	if ( is_search() && $options[ 'search_integration' ] === 'on' ) {
	
		global $wp_query;
		$posts = $wp_query->posts;
		
		$post_ids = array();
		forEach ( $posts as $p ) {
			if ( $p->post_type === 'download' ) {
				$post_ids[] = $p->ID;
			}
		}
		
		if ( !empty ( $post_ids ) ) {
			wp_localize_script( 'fca_pc_client_js', 'fcaPcSearchQuery', array('search_string' => get_search_query(), 'content_ids' => $post_ids, 'adapter' => 'edd' ) );
		} else {
			wp_localize_script( 'fca_pc_client_js', 'fcaPcSearchQuery', array( 'search_string' => get_search_query() ) );
		}
	}	
}
add_action( 'fca_pc_start_pixel_output', 'fca_pc_edd_event_search' );

function fca_pc_edd_event_view_product() {
	global $post;

	if ( $post && $post->post_type === 'download' ) {
		$download = new EDD_Download( $post->ID );
		$data = array(
			'value' => $download->get_price(),
			'currency' => edd_get_option( 'currency', 'USD' ),
			'content_name' => esc_html( strip_tags( get_the_title(  $post->ID ) ) ),
			'content_ids' => array( $post->ID ),
			'content_type' => $download->has_variable_prices() ? 'product_group' : 'product',
		);

		wp_localize_script( 'fca_pc_client_js', 'fcaPcEddProduct', $data );
	}
}
add_action( 'fca_pc_start_pixel_output', 'fca_pc_edd_event_view_product' );

function fca_pc_edd_event_initiate_checkout() {
	if ( function_exists('edd_is_checkout') && edd_is_checkout() ) {
		wp_localize_script( 'fca_pc_client_js', 'fcaPcEddCheckoutCart', fca_pc_edd_format_cart_data() );
	}
}
add_action( 'fca_pc_start_pixel_output', 'fca_pc_edd_event_initiate_checkout' );


function fca_pc_edd_purchase( $payment_id ) {
	$options = get_option( 'fca_pc', array() );
	$edd_extra_params = empty( $options['edd_extra_params'] ) ? false : true;
	$advanced_matching = empty ( $options['advanced_matching'] ) ? false : true;
	
	$cart = fca_pc_edd_format_cart_data( $payment_id, $edd_extra_params );
	setcookie( 'fca_pc_edd_purchase', json_encode( $cart ), 0, '/' );
	if ( $advanced_matching ) {
		$payment = new EDD_Payment( $payment_id );
		$user_data = array (
			'email' => $payment->email,
			'fn' 	=> $payment->first_name,
			'ln' 	=> $payment->last_name,
			'ct' 	=> $payment->address['city'],
			'st' 	=> $payment->address['state'],
			'zp' 	=> $payment->address['zip']
		);
		
		//USER DATA SHOULD BE LOWERCASE https://developers.facebook.com/docs/facebook-pixel/pixel-with-ads/conversion-tracking#advanced_match

		setcookie( 'fca_pc_advanced_matching', json_encode( array_map( 'strtolower', array_filter( $user_data ) ) ), 0, '/' );

	}
}
add_action( 'edd_complete_purchase', 'fca_pc_edd_purchase', 9999, 1 );

function fca_pc_edd_format_cart_data( $payment_id = false, $extra_params = false ) {
	if ( $payment_id ) {
		$cart_contents = edd_get_payment_meta_cart_details( $payment_id );
	} else {
		$cart_contents = edd_get_cart_contents();
	}
	
	$num_items = 0;
	$value = 0;
	$content_name = array();
	$content_category = array();
	$content_ids = array();
	
	forEach ( $cart_contents as $item ) {
		$download = new EDD_Download( $item['id'] );
		$num_items = $num_items + $item['quantity'];
		if ( !empty( $item['price'] ) ) {
			$value = $value + $item['price'];
		} else if ( $download->has_variable_prices() ) {
			$price_id = $item['options']['price_id'];
			$value = $value + $download->get_prices()[$price_id]['amount'];
		} else {
			$value = $value + $download->get_price();
		}
				
		$content_name[] = esc_html( strip_tags( get_the_title( $item['id'] ) ) );
		$content_ids[] = $item['id'];
		$category = get_the_terms( $item['id'], 'download_category' );
		
		if ( $category ) {
			foreach ( $category as $term  ) {
				$content_category[] = $term->name;
			}
		}
	}
	
	$cart_data = array(
		'value' => $value,
		'currency' => edd_get_option( 'currency', 'USD' ),
		'content_name' => implode( ', ', $content_name),
		'content_ids' => $content_ids,
		'num_items' => $num_items,
		'content_type' => 'product',
	);
	
	if ( $extra_params ) {
		$payment = new EDD_Payment( $payment_id );
		$customer = new EDD_Customer( get_current_user_id(), true );

		$cart_data['gateway'] = $payment->gateway;
		$address = $payment->address;
		
		$address_keys = array(
			'city' => 'billing_city',
			'state' => 'billing_state',
		);
		forEach ( $address_keys as $key => $value ) {
			if ( $address[$key] ) {
				$cart_data[$value] = $address[$key];	
			}
		}
				
		$cart_data['lifetime_value'] = round( $customer->purchase_value, 2);	
		
		if ( edd_get_cart_discounts() ) {
			$cart_data['discount_code'] = edd_get_cart_discounts();
		}
	}
	
	if ( count( $content_category ) > 0 ) {
		$cart_data['content_category'] = implode( ', ', $content_category );
	}
	return $cart_data;
}
