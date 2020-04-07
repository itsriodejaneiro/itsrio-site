<?php

////////////////////////////
// FUNCTIONS
////////////////////////////

function fca_pc_post_parameters() {
	global $post;

	$post_id = empty ( $post->ID ) ? 0 : $post->ID;
	$options = get_option( 'fca_pc', array() );

	return array(
		'title' => empty ( $post->post_title ) ? '' : $post->post_title,
		'type' => empty ( $post->post_type ) ? '' : $post->post_type,
		'id' => $post_id,
		'categories' => fca_pc_get_category_names( $post_id ),
		'utm_support' => empty( $options['utm_support'] ) ? false : true,
		'user_parameters' => empty( $options['user_parameters'] ) ? false : true,
		'edd_delay' => empty( $options['edd_delay'] ) ? 0 : intVal($options['edd_delay']),
		'woo_delay' => empty( $options['woo_delay'] ) ? 0 : intVal($options['woo_delay']),
		'edd_enabled' => empty( $options['edd_integration'] ) ? false : true,
		'woo_enabled' => empty( $options['woo_integration'] ) ? false : true,
		'video_enabled' => empty( $options['video_events'] ) ? false : true,
	);
}
function fca_pc_get_active_events( $id = '' ) {

	if ( !$id ) {
		$id = get_the_id();
	}

	$options = get_option( 'fca_pc', array() );
	$events = empty( $options['events'] ) ? array() : stripslashes_deep( $options['events'] );

	$categories = wp_get_post_categories( $id );
	$tags = wp_get_post_tags( $id );

	$active_events = array();
	if ( !empty ( $events ) ) {
		forEach ( $events as $event ) {
			$event = json_decode( $event );

			if ( !empty( $event->paused ) ) {
				//skip this one
				continue;
			}

			if ( is_array( $event->trigger ) ) {
				$post_id_match = in_array( $id, $event->trigger );
				//CHECK CATEGORIES & TAGS
				$category_match = count( array_intersect( array_map( 'fca_pc_cat_id_fiter', $categories ), $event->trigger ) ) > 0;
				$tag_match = count( array_intersect( array_map( 'fca_pc_tag_id_fiter', $tags ), $event->trigger ) ) > 0;
				$front_page_match = is_front_page() && in_array( 'front', $event->trigger );
				$blog_page_match = is_home() && in_array( 'blog', $event->trigger );
				if ( in_array( 'all', $event->trigger ) OR $post_id_match OR $category_match OR $front_page_match OR $blog_page_match OR $tag_match ) {
					$active_events[] = $event;
				}
			} else {
				//CSS TRIGGERS
				$active_events[] = $event;
			}

		}
	}

	return $active_events;

}

function fca_pc_advanced_matching() {

	if ( !empty( $_COOKIE['fca_pc_advanced_matching'] ) ) {
		return stripslashes_deep( $_COOKIE['fca_pc_advanced_matching'] );
	} else if ( is_user_logged_in() ) {

		$user = wp_get_current_user();

		$fn = empty( $user->first_name ) ? $user->billing_first_name : $user->first_name;
		$ln = empty( $user->last_name ) ? $user->billing_last_name : $user->last_name;
		$user_data = array (
			'em' => $user->user_email,
			'fn' 	=> $fn,
			'ln' 	=> $ln,
			'ph' 	=> $user->billing_phone,
			'ct' 	=> $user->billing_city,
			'st' 	=> $user->billing_state,
			'zp' 	=> $user->billing_postcode
		);

		return json_encode( array_map( 'strtolower', array_filter( $user_data ) ) );

	} else if ( function_exists('is_order_received_page') && is_order_received_page() ) {

		global $wp;
		$order_id = isset( $wp->query_vars['order-received'] ) ? intval( $wp->query_vars['order-received'] ) : 0;
		$order = new WC_Order( $order_id );

		$user_data = array (
			'em' => $order->get_billing_email(),
			'fn' 	=> $order->get_billing_first_name(),
			'ln' 	=> $order->get_billing_last_name(),
			'ct' 	=> $order->get_billing_city(),
			'st' 	=> $order->get_billing_state(),
			'zp' 	=> $order->get_billing_postcode(),
		);

		return json_encode( array_map( 'strtolower', array_filter( $user_data ) ) );

	}

	return false;
}

function fca_pc_user_parameters( $id = '' ) {

	if ( !$id ) {
		$id = get_the_id();
	}

	return array(
		'referrer' => wp_get_raw_referer(),
		'language' => sanitize_text_field( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ),
		'logged_in' => is_user_logged_in() ? 'true' : 'false',
		'post_tag' => implode( ', ', array_map( 'fca_pc_tag_name_fiter', wp_get_post_tags( $id ) ) ),
		'post_category' => implode( ', ', fca_pc_get_category_names( $id ) ),
	);
}

function fca_pc_get_category_names( $id = '' ){

	if ( !$id ) {
		$id = get_the_id();
	}

	$category_names = array();
	$categories = wp_get_post_categories( $id );
	if ( is_array( $categories ) ) {
		forEach ( $categories as $cat_id ) {
			$category_names[] = get_cat_name( $cat_id );
		}
	}
	return $category_names;
}

function fca_pc_woo_product_cat_and_tags() {

	$return = array();

	$tags = get_terms( 'product_tag' );
	if ( !is_array( $tags ) ) {
		$tags = array();
	}
	$cats = get_terms( 'product_cat' );
	if ( !is_array( $cats ) ) {
		$cats = array();
	}
	forEach ( array_merge( $cats, $tags ) as $obj ) {
		$return[$obj->term_id] = $obj->name;
	}
	return $return;
}

function fca_pc_edd_product_cat_and_tags() {

	$return = array();

	$tags = get_terms( 'download_tag' );
	if ( !is_array( $tags ) ) {
		$tags = array();
	}
	$cats = get_terms( 'download_category' );
	if ( !is_array( $cats ) ) {
		$cats = array();
	}
	forEach ( array_merge( $cats, $tags ) as $obj ) {
		$return[$obj->term_id] = $obj->name;
	}
	return $return;
}


//RETURN GENERIC INPUT HTML
function fca_pc_input ( $name, $placeholder = '', $value = '', $type = 'text', $atts = '' ) {

	$html = "<div class='fca-pc-field fca-pc-field-$type'>";

		switch ( $type ) {

			case 'checkbox':
				$checked = !empty( $value ) ? "checked='checked'" : '';

				$html .= "<div class='onoffswitch'>";
					$html .= "<input $atts style='display:none;' type='checkbox' id='fca_pc[$name]' class='onoffswitch-checkbox fca-pc-input-$type fca-pc-$name' name='fca_pc[$name]' $checked>";
					$html .= "<label class='onoffswitch-label' for='fca_pc[$name]'><span class='onoffswitch-inner' data-content-on='ON' data-content-off='OFF'><span class='onoffswitch-switch'></span></span></label>";
				$html .= "</div>";
				break;

			case 'textarea':
				$html .= "<textarea $atts placeholder='$placeholder' class='fca-pc-input-$type fca-pc-$name' name='fca_pc[$name]'>$value</textarea>";
				break;

			case 'image':
				$html .= "<input type='hidden' class='fca-pc-input-$type fca-pc-$name' name='fca_pc[$name]' value='$value'>";
				$html .= "<button type='button' class='button-secondary fca_pc_image_upload_btn'>" . __('Add Image', 'facebook-conversion-pixel') . "</button>";
				$html .= "<img class='fca_pc_image' style='max-width: 252px' src='$value'>";

				$html .= "<div class='fca_pc_image_hover_controls'>";
					$html .= "<button type='button' class='button-secondary fca_pc_image_change_btn'>" . __('Change', 'facebook-conversion-pixel') . "</button>";
					$html .= "<button type='button' class='button-secondary fca_pc_image_revert_btn'>" . __('Remove', 'facebook-conversion-pixel') . "</button>";
				$html .=  '</div>';
				break;
			case 'color':
				$html .= "<input $atts type='hidden' placeholder='$placeholder' class='fca-pc-input-$type fca-pc-$name' name='fca_pc[$name]' value='$value'>";
				break;
			case 'editor':
				ob_start();
				wp_editor( $value, $name, array() );
				$html .= ob_get_clean();
				break;
			case 'datepicker':
				$html .= "<input $atts type='text' placeholder='$placeholder' class='fca-pc-input-$type fca-pc-$name' name='fca_pc[$name]' value='$value'>";
				break;
			case 'roles':
				$roles = get_editable_roles();
				forEach ( $roles as $role ) {
					$options[] = $role['name'];
				}
				$html = "<select $atts name='fca_pc[$name][]' data-placeholder='$placeholder' multiple='multiple' style='width: 100%; border: 1px solid #ddd; border-radius: 0;' class='fca_pc_multiselect'>";
					forEach ( $options as $role ) {
						if ( in_array($role, $value) ) {
							$html .= "<option value='$role' selected='selected'>$role</option>";
						} else {
							$html .= "<option value='$role'>$role</option>";
						}
					}

				$html .= "</select>";
				break;
			case 'hidden':
				$html .= "<input $atts type='hidden' class='fca-pc-input-$type fca-pc-$name' name='fca_pc[$name]' value='$value'>";
				break;

			default:
				$html .= "<input $atts type='$type' placeholder='$placeholder' class='fca-pc-input-$type fca-pc-$name' name='fca_pc[$name]' value='$value'>";
		}

	$html .= '</div>';

	return $html;
}

function fca_pc_sanitize_text_array( $array ) {
	if ( !is_array( $array ) ) {
		return sanitize_text_field ( $array );
	}
	foreach ( $array as $key => &$value ) {
		if ( is_array( $value ) ) {
			$value = fca_sp_sanitize_text_array( $value );
		} else {
			$value = sanitize_text_field( $value );
		}
	}

	return $array;
}


//SINGLE-SELECT
function fca_pc_select( $name, $selected = '', $options = array() ) {
	$html = "<div class='fca-pc-field fca-pc-field-select'>";
		$html .= "<select name='fca_pc[$name]' class='fca-pc-input-select fca-pc-$name'>";
			if ( empty( $options ) && !empty ( $selected ) ) {
				$html .= "<option selected='selected' value='$selected'>" . __('Loading...', 'facebook-conversion-pixel') . "</option>";
			} else {
				forEach ( $options as $key => $text ) {
					$sel = $selected === $key ? 'selected="selected"' : '';
					$html .= "<option $sel value='$key'>$text</option>";
				}
			}
		$html .= '</select>';
	$html .= '</div>';

	return $html;
}

function fca_pc_delete_icons() {
	ob_start(); ?>
		<span class='dashicons dashicons-trash fca_delete_icon fca_delete_button' title='<?php _e('Delete', 'facebook-conversion-pixel' ) ?>'></span>
		<span class='dashicons dashicons-yes fca_delete_icon fca_delete_icon_confirm' title='<?php _e('Confirm Delete', 'facebook-conversion-pixel' ) ?>' style='display:none;'></span>
		<span class='dashicons dashicons-no fca_delete_icon fca_delete_icon_cancel' title='<?php _e('Cancel', 'facebook-conversion-pixel' ) ?>' style='display:none;'></span>
	<?php
	return ob_get_clean();
}

function fca_pc_tooltip( $text = 'Tooltip', $icon = 'dashicons dashicons-editor-help' ) {
	return "<span class='$icon fca_pc_tooltip' title='" . htmlentities( $text ) . "'></span>";
}

function fca_pc_convert_entities ( $array ) {
	$array = is_array($array) ? array_map('fca_pc_convert_entities', $array) : html_entity_decode( $array, ENT_QUOTES );
	return $array;
}

function fca_pc_bigintval( $value ) {
	$value = trim($value);

	if ( ctype_digit($value) ) {
		return $value;
	}

	$value = preg_replace("/[^0-9](.*)$/", '', $value);

	if ( ctype_digit($value ) ) {
		return $value;
	}
		return 0;
}

//HELPER FILTERS
function fca_pc_cat_id_fiter ( $cat_id ) {
	return 'cat' . $cat_id;
}
function fca_pc_tag_id_fiter ( $tag_id ) {
	return 'tag' . $tag_id->term_id;
}
function fca_pc_tag_name_fiter ( $tag ) {
	return $tag->name;
}
function fca_pc_term_id_fiter ( $obj ) {
	return $obj->term_id;
}

function fca_pc_content_filter( $content ) {

	$api_parameter = '?enablejsapi=1';

	$pattern = '/(?P<youtube_url>https:\/\/www\.youtube\.com\/embed\/)(?P<youtube_id>.*?)(?=[\?"])/i';

	preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
	
	if (empty($matches)) {
		return $content;
	}

	$str_matches = array();

	$str_replaces = array();

	foreach ($matches as $match) {

		if (empty($match)) {
			continue;
		}

		if (strpos($match[0], $api_parameter) != false) {
			continue;
		}

		$src_api = $match[0] . $api_parameter;

		$str_matches[] = $match[0];

		$str_replaces[] = $src_api;
	}

	$str_matches = array_unique($str_matches);

	$str_replaces = array_unique($str_replaces);

	$content = str_replace($str_matches , $str_replaces, $content);

	return $content;
}
add_filter( 'the_content', 'fca_pc_content_filter' );