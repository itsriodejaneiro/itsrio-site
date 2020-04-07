<?php

function fca_pc_woo_product_page( $options ) {
	if ( function_exists('is_product') && is_product() ) {
	
		$p = fca_pc_get_woo_product();
		
		if ( $p ) {
			
			$woo_id_mode = empty( $options['woo_product_id'] ) ? 'post_id' : $options['woo_product_id'];
			$id = $woo_id_mode === 'post_id' ? $p->get_id() : $p->get_sku();
			$content_type = $p->get_type() === 'variable' ? 'product_group' : 'product';
			
			$data = array(
				'value' => wc_get_price_to_display( $p ),
				'currency' => get_woocommerce_currency(),
				'content_name' => $p->get_title(),
				'content_ids' => array( $id ),
				'content_type' => $content_type,
			);

			wp_localize_script( 'fca_pc_client_js', 'fcaPcWooProduct', $data );
		}
	}
}
add_action( 'fca_pc_start_pixel_output', 'fca_pc_woo_product_page', 10, 1 );

function fca_pc_woo_add_to_cart( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
	
	$p = fca_pc_get_woo_product( $product_id );

	if ( $p ) {
		
		$options = get_option( 'fca_pc', array() );
		$woo_id_mode = empty( $options['woo_product_id'] ) ? 'post_id' : $options['woo_product_id'];
		$id = $woo_id_mode === 'post_id' ? $p->get_id() : $p->get_sku();
		$content_type = $p->get_type() === 'variable' ? 'product_group' : 'product';
		
		$data = array(
			'value' => wc_get_price_to_display( $p ),
			'currency' => get_woocommerce_currency(),
			'content_name' => $p->get_title(),
			'content_ids' => array( $id ),
			'content_type' => $content_type,
		);
		setcookie( 'fca_pc_woo_add_to_cart', json_encode( $data ), 0, '/' );
		
	}
}
add_action( 'woocommerce_add_to_cart', 'fca_pc_woo_add_to_cart', 10, 6 );

function fca_pc_initiate_checkout( $options ) {
	if ( function_exists('is_checkout') && is_checkout() && !is_order_received_page() ) {
		$num_items = 0;
		$value = 0;
		$content_name = array();
		$content_category = array();
		$content_ids = array();
		
		$woo_id_mode = empty( $options['woo_product_id'] ) ? 'post_id' : $options['woo_product_id'];
				
		forEach ( WC()->cart->get_cart() as $item ) {
			
			$num_items = $num_items + $item['quantity'];
			$value = $value + $item['line_total'];
			$content_name[] = get_the_title( $item['product_id'] );
			$content_ids[] = $woo_id_mode === 'post_id' ? $item['product_id'] : wc_get_product( $item['product_id'] )->get_sku();
			$category = get_the_terms( $item['product_id'], 'product_cat' );
			if ( $category ) {
				forEach ( $category as $term  ) {
					$content_category[] = $term->name;
				}
			}
		}
		
		$cart_data = array(
			'value' => $value,
			'currency' => get_woocommerce_currency(),
			'content_name' => implode( ', ', $content_name),
			'content_ids' => $content_ids,
			'num_items' => $num_items,
			'content_type' => 'product'
		);
		
		if ( count( $content_category ) > 0 ) {
			$cart_data['content_category'] = implode( ', ', $content_category );
		}

		wp_localize_script( 'fca_pc_client_js', 'fcaPcWooCheckoutCart', $cart_data );
	}
}
add_action( 'fca_pc_start_pixel_output', 'fca_pc_initiate_checkout', 10, 1 );

function fca_pc_purchase( $options ) {
	//WOOCOMMERCE THANK YOU REDIRECT PLUGIN SUPPORT
	$is_thank_you_page = isset( $_GET['order'] ) && isset( $_GET['key'] );
	
	if ( function_exists('is_order_received_page') && ( is_order_received_page() OR $is_thank_you_page ) ) {
		
		global $wp;
		$order_id = isset( $wp->query_vars['order-received'] ) ? intval( $wp->query_vars['order-received'] ) :  intval( $wp->query_vars['order'] );
		$order = new WC_Order( $order_id );
		
		$num_items = 0;
		$value = 0;
		$content_name = array();
		$content_category = array();
		$content_ids = array();
		
		$woo_id_mode = empty( $options['woo_product_id'] ) ? 'post_id' : $options['woo_product_id'];
		$woo_extra_params = empty( $options['woo_extra_params'] ) ? false : true;
		
		forEach ( $order->get_items() as $item ) {
			$num_items = $num_items + $item['qty'];
			$value = $value + $item['line_total'];
			$content_name[] = get_the_title( $item['product_id'] );
			$content_ids[] = $woo_id_mode === 'post_id' ? $item['product_id'] : wc_get_product( $item['product_id'] )->get_sku();
			$category = get_the_terms( $item['product_id'], 'product_cat' );
			if ( $category ) {
				forEach ( $category as $term  ) {
					$content_category[] = $term->name;
				}
			}
		}
		
		$cart_data = array(
			'value' => $value,
			'currency' => get_woocommerce_currency(),
			'content_name' => implode( ', ', $content_name),
			'content_ids' => $content_ids,
			'num_items' => $num_items,
			'content_type' => 'product',
		);
		
		if ( $woo_extra_params ) {
			
			$cart_data['lifetime_value'] = fca_pc_get_woo_ltv( $order->get_billing_email() );
			
			$extra_params = array(
				'get_used_coupons' => 'discount_code',
				'get_billing_city' => 'billing_city',
				'get_billing_state' => 'billing_state',
				'get_payment_method' => 'payment_method',
				'get_shipping_method' => 'shipping_method',
			);
			
			forEach ( $extra_params as $key => $value ) {
				if ( $order->$key() ) {
					$cart_data[$value] = $order->$key();
				}	
			}
			
			if ( $order->get_used_coupons() ) {
				$cart_data['discount_code'] = $order->get_used_coupons();
			}
			
		}
		
		if ( count( $content_category ) > 0 ) {
			$cart_data['content_category'] = implode( ', ', $content_category );
		}
		
		wp_localize_script( 'fca_pc_client_js', 'fcaPcWooPurchase', $cart_data );
	}
}
add_action( 'fca_pc_start_pixel_output', 'fca_pc_purchase', 10, 1 );


function fca_pc_woocommerce_search() {

	$options = get_option( 'fca_pc' );
	
	if ( is_search() && $options[ 'search_integration' ] === 'on' ) {
		global $wp_query;
		$posts = $wp_query->posts;
		
		$post_ids = array();
		forEach ( $posts as $p ) {
			if ( $p->post_type === 'product' ) {
				$post_ids[] = $p->ID;
			}
		}
		wp_localize_script( 'fca_pc_client_js', 'fcaPcSearchQuery', array('search_string' => get_search_query(), 'content_ids' => $post_ids, 'adapter' => 'woo' ) );
	}
}
add_action( 'fca_pc_start_pixel_output', 'fca_pc_woocommerce_search', 10, 1 );


function fca_pc_get_woo_product ( $product_id = '') {
	$p = empty( $product_id ) ? wc_get_product() : wc_get_product( $product_id );
	if ( $p ) {
		return $p;
	}
	return false;
}

function fca_pc_get_woo_ltv( $email ) {
	
	$ltv = 0;
	
	$args = array(
		'post_type'      => 'shop_order',
		'post_status'    => 'wc-completed',
		'meta_key'       => '_billing_email',
		'meta_value'     => $email,
		'posts_per_page' => -1,
	);

	$orders_query = new WP_Query( $args );

	foreach( $orders_query->posts as $order ) {
		$WC_Order = new WC_Order( $order );
		$ltv += $WC_Order->get_total();
	}

	wp_reset_query();
	
	return $ltv;
	
}
